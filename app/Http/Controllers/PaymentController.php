<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with(['userDetail'])->findOrFail(Auth::id());
        $vehicle = Vehicle::with(['car', 'motorcycle', 'category'])->findOrFail($request->vehicle_id);
        $existingRentals = Rental::where('vehicle_id', $vehicle->id)
            ->where('status', 'ongoing')
            ->get(['rental_date', 'return_date_scheduled']);

        $bookedDates = [];
        foreach ($existingRentals as $rental) {
            $start = Carbon::parse($rental->rental_date);
            $end = Carbon::parse($rental->return_date_scheduled);

            while ($start->lte($end)) {
                $bookedDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        $bookedDates = array_values(array_unique($bookedDates));

        return view('pembayaran', compact('user', 'vehicle', 'bookedDates'));
    }

    public function generateTripayPayment(Request $request)
    {
        $user = User::with(['userDetail'])->findOrFail(Auth::id());

        $apiKey = env('TRIPAY_API_KEY');
        $privateKey = env('TRIPAY_PRIVATE_KEY');
        $merchantCode = env('TRIPAY_MERCHANT_CODE');

        $rental = null;
        $totalHargaSewa = 0;

        if ($request->filled('merchant_ref')) {
            $rental = Rental::where('merchant_ref', $request->merchant_ref)->first();
            if ($rental) {
                $totalHargaSewa = $rental->total_price;
            }
        }

        if (!$totalHargaSewa && $request->filled('total_price')) {
            $totalHargaSewa = $request->total_price;
        }

        if (!$rental && !$request->filled('total_price')) {
            return response()->json([
                'success' => false,
                'message' => 'Data referensi pembayaran atau total harga tidak valid.'
            ], 400);
        }

        if ($request->has('cancel_reference') && !empty($request->cancel_reference)) {
            try {
                $cancelUrl = 'https://tripay.co.id/api-sandbox/merchant/transactions/void';
                Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post($cancelUrl, [
                    'reference' => $request->cancel_reference
                ]);
                Log::info('Tripay Auto-Cancel Berhasil untuk Referensi: ' . $request->cancel_reference);
            } catch (\Exception $e) {
                Log::error('Tripay Auto-Cancel Gagal: ' . $e->getMessage());
            }
        }

        $baseUrl = 'https://tripay.co.id/api-sandbox/transaction/create';
        $merchantRef = $rental->merchant_ref ?? 'CAP-' . time() . '-' . rand(1000, 9999);

        $custName = $user->username;
        $custEmail = $user->email;
        $custPhone = $user->userDetail->phone ?? '';
        $duration = $rental->duration ?? 1;

        $amount = ($totalHargaSewa * 10) / 100;
        $amount = $amount < 20000 ? 20000 : $amount;

        if ($request->filled('remaining')) {
            $sanitizeInput = str_replace(',', '.', $request->remaining);
            $cleanRemaining = preg_replace('/[^0-9.]/', '', $sanitizeInput);
            if (substr_count($cleanRemaining, '.') > 1) {
                $cleanRemaining = str_replace('.', '', substr($cleanRemaining, 0, strrpos($cleanRemaining, '.'))) . substr($cleanRemaining, strrpos($cleanRemaining, '.'));
            }

            $amount = floor((float) $cleanRemaining);
        }

        $amount = (int) ceil((float) $amount);
        $amountString = number_format($amount, 0, '', '');

        if ($amount > 10000000 && in_array($request->method, ['QRIS', 'OVO', 'DANA', 'LINKAJA', 'SHOPEEPAY'])) {
            return response()->json([
                'success' => false,
                'message' => 'Nominal transaksi (Rp ' . number_format($amount, 0, ',', '.') . ') melebihi batas maksimal metode instan. Silakan gunakan Transfer Virtual Account (VA).'
            ], 400);
        }

        $signature = hash_hmac('sha256', $merchantCode . $merchantRef . $amountString, $privateKey);
        $payload = [
            'method'         => $request->method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $request->name ?? $custName,
            'customer_email' => $request->email ?? $custEmail,
            'customer_phone' => $request->phone ?? $custPhone,
            'order_items'    => [
                [
                    'sku'      => 'SEWA-KENDARAAN',
                    'name'     => 'Sewa Mobil ' . ($request->days ?? $duration) . ' Hari',
                    'price'    => $amount,
                    'quantity' => 1
                ]
            ],
            'expired_time'   => (time() + (24 * 60 * 60)),
            'signature'      => $signature
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey
        ])->post($baseUrl, $payload);

        if ($response->successful()) {
            $result = $response->json();
            return response()->json([
                'success' => true,
                'data' => $result['data'],
                'merchant_ref' => $merchantRef,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat transaksi di Tripay',
            'detail' => $response->json()
        ], 400);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16',
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup' => 'required|string',
            'deliver' => 'required|string',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'jam' => 'required',
            'days' => 'required|integer|min:1',
            'total' => 'required|numeric',
            'no_va' => 'required',
            'reference' => 'required|string',
            'method' => 'required|string',
            'merchant_ref' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $rentalDateTime = Carbon::parse($request->rental_date . ' ' . $request->jam);
            $returnDateTime = Carbon::parse($request->return_date . ' ' . $request->jam);
            $amount = ($request->total * 10) / 100;

            $amount = $amount < 20000 ? 20000 : $amount;

            $merchantRef = $request->merchant_ref;

            $rental = Rental::create([
                'user_id' => Auth::id(),
                'merchant_ref' => $merchantRef,
                'NIK' => $request->nik,
                'vehicle_id' => $request->vehicle_id,
                'rental_date' => $rentalDateTime,
                'return_date_scheduled' => $returnDateTime,
                'duration' => $request->days,
                'pickup_location' => $request->pickup,
                'deliver_to_location' => $request->deliver,
                'total_price' => $request->total,
                'amount_paid' => $amount,
                'status' => 'pending',
            ]);

            $feeAmount = 4500;

            Payment::create([
                'reference' => $request->reference,
                'no_va' => $request->no_va,
                'rental_id' => $rental->id,
                'total_bill' => $request->total,
                'amount' => $amount + $feeAmount,
                'fee_amount' => $feeAmount,
                'net_amount' => $amount,
                'payment_method' => $request->method,
                'payment_type' => 'dp',
                'payment_name' => $request->method,
                'status' => 'unpaid',
            ]);

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Transaksi sewa berhasil disimpan.',
                'merchant_ref' => $merchantRef
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function pelunasan(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:rentals,id',
            'total' => 'required|numeric',
            'no_va' => 'required',
            'reference' => 'required|string',
            'method' => 'required|string',
            'merchant_ref' => 'required|string',
        ]);

        $rental = Rental::where('merchant_ref', $request->merchant_ref)->first();

        DB::beginTransaction();
        try {
            $amount = $request->total;
            $feeAmount = 4250;
            $method = strtoupper($request->method);

            Payment::create([
                'reference' => $request->reference,
                'no_va' => $request->no_va,
                'rental_id' => $rental->id,
                'total_bill' => $request->total,
                'amount' => $amount + $feeAmount,
                'fee_amount' => $feeAmount,
                'net_amount' => $amount,
                'payment_method' => $method,
                'payment_type' => 'repayment',
                'payment_name' => $method,
                'status' => 'unpaid',
            ]);

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Transaksi sewa berhasil disimpan.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal: ' . $e->getMessage()
            ], 500);
        }
    }
}
