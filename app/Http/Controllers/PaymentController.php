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

        return view('pembayaran', compact('user', 'vehicle'));
    }

    public function generateTripayPayment(Request $request)
    {
        $apiKey = env('TRIPAY_API_KEY');
        $privateKey = env('TRIPAY_PRIVATE_KEY');
        $merchantCode = env('TRIPAY_MERCHANT_CODE');

        if ($request->has('cancel_reference') && !empty($request->cancel_reference)) {
            try {
                $cancelUrl = 'https://tripay.co.id/api-sandbox/merchant/transactions/void';

                Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey
                ])->post($cancelUrl, [
                    'reference' => $request->cancel_reference
                ]);

                Log::info('Tripay Auto-Cancel Berhasil untuk Referensi: ' . $request->cancel_reference);
            } catch (\Exception $e) {
                Log::error('Tripay Auto-Cancel Gagal: ' . $e->getMessage());
            }
        }

        $baseUrl = 'https://tripay.co.id/api-sandbox/transaction/create';
        $merchantRef = 'INV-' . time();
        $amount = ($request->total * 10) / 100;
        $amount = $amount < 20000 ? 20000 : $amount;

        $signature = hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey);

        $payload = [
            'method'         => $request->method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'order_items'    => [
                [
                    'sku'      => 'SEWA-KENDARAAN',
                    'name'     => 'Sewa Mobil ' . $request->days . ' Hari',
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
                'data' => $result['data']
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
            'nik'         => 'required|digits:16',
            'vehicle_id'  => 'required|exists:vehicles,id',
            'pickup'      => 'required|string',
            'deliver'     => 'required|string',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'jam'         => 'required',
            'days'        => 'required|integer|min:1',
            'total'       => 'required|numeric',
            'no_va'       => 'required', // Dihapus tipe integer karena beberapa VA bank/e-wallet bisa sangat panjang atau bertipe string
            'reference'   => 'required|string',
            'method'      => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $rentalDateTime = Carbon::parse($request->rental_date . ' ' . $request->jam);
            $returnDateTime = Carbon::parse($request->return_date . ' ' . $request->jam);
            $amount = ($request->total * 10) / 100;

            $amount = $amount < 20000 ? 20000 : $amount;

            $randomId = rand(10000, 90000);
            $merchantRef = "CAP-2026-" . $randomId;

            $rental = Rental::create([
                'user_id'               => Auth::id(),
                'NIK'                   => $request->nik,
                'vehicle_id'            => $request->vehicle_id,
                'rental_date'           => $rentalDateTime,
                'return_date_scheduled' => $returnDateTime,
                'duration'              => $request->days,
                'pickup_location'       => $request->pickup,
                'deliver_to_location'   => $request->deliver,
                'total_price'           => $request->total,
                'amount_paid'           => $amount,
                'status'                => 'pending',
            ]);

            $feeAmount = 4500;

            Payment::create([
                'reference'      => $request->reference,
                'merchant_ref'   => $merchantRef,
                'no_va'          => $request->no_va,
                'rental_id'      => $rental->id,
                'total_bill'     => $request->total,
                'amount'         => $amount + $feeAmount,
                'fee_amount'     => $feeAmount,
                'net_amount'     => $amount,
                'payment_method' => $request->method,
                'payment_type'   => 'dp',
                'payment_name'   => $request->method,
                'status'         => 'unpaid',
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
}
