<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TripayCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $privateKey = env('TRIPAY_PRIVATE_KEY');

        $callbackSignature = $request->header('X-Callback-Signature');
        $json = $request->getContent();

        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($callbackSignature !== $signature) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Signature'
            ], 403);
        }

        if ('payment_status' !== $request->header('X-Callback-Event')) {
            return response()->json([
                'success' => false,
                'message' => 'Unrecognized Event'
            ], 400);
        }

        $data = json_decode($json);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid JSON Data'
            ], 400);
        }

        $payment = Payment::where('reference', $data->reference)->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment Reference Not Found'
            ], 404);
        }
        $statusTripay = strtoupper($data->status);

        DB::beginTransaction();
        try {
            if ($statusTripay === 'PAID') {
                $payment->update(['status' => 'paid']);

                $rental = Rental::find($payment->rental_id);
                if ($rental) {
                    $rental->update([
                        'status' => 'ongoing',
                        'amount_paid' => $payment->net_amount
                    ]);
                }

                Log::info("Webhook Tripay Sukses: Pembayaran ID {$payment->id} telah LUNAS.");
            } elseif (in_array($statusTripay, ['EXPIRED', 'FAILED'])) {
                $payment->update(['status' => strtolower($statusTripay)]);

                $rental = Rental::find($payment->rental_id);
                if ($rental) {
                    $rental->update(['status' => 'cancelled']);
                }
                Log::warning("Webhook Tripay: Pembayaran ID {$payment->id} GAGAL/EXPIRED.");
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Callback diproses dengan sukses'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Webhook Tripay Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem internal: ' . $e->getMessage()
            ], 500);
        }
    }
}
