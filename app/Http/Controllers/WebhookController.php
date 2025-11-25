<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebhookModel;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $webhook_secret = env('Webhook_Secret');
        $webhook_signature = $request->header('Paymongo_Signature');
        \Log::info('Paymongo Signature: ' . $webhook_signature); // <-- moved here
        $event_datas = $request->getContent();
        $event_filter = json_decode($event_datas, true);

        if (!$webhook_signature) {
            return response()->json(['error' => 'Missing signature'], 400);
        }

        // Parse signature header
        $parts = [];
        foreach (explode(',', $webhook_signature) as $part) {
            [$k, $v] = explode('=', $part, 2);
            $parts[trim($k)] = $v;
        }

        if (!isset($parts['t'], $parts['te'])) {
            return response()->json(['error' => 'Invalid signature format'], 400);
        }

        $webhook_signature_time = $parts['t'];
        $webhook_signature_data = $parts['te'];
        $webhook_time_with_json_data = $webhook_signature_time . '.' . $event_datas;
        $computedSignature = hash_hmac('sha256', $webhook_time_with_json_data, $webhook_secret);

        $mySignature = hash_equals($computedSignature, $webhook_signature_data);

        if ($mySignature) {
            $type = $event_filter['data']['attributes']['type'] ?? 'unknown';

            // // Only save payment details for successful payments
            // if ($type === 'payment.paid') {
            //     $attributes = $event_filter['data']['attributes'];

            //     Payment::create([
            //         // 'id' => $attributes['id'], // Usually auto-incremented by DB
            //         'card'         => $attributes['payment_method_details']['card']['last4'] ?? null,
            //         'cash'         => null,
            //         'amount'       => $attributes['amount'] ?? 0,
            //         'payment_code' => $attributes['payment_code'] ?? null,
            //         'created_at'   => now(),
            //         'bookings_id'  => $attributes['metadata']['bookings_id'] ?? null,
            //     ]);
            // }
            $paymentData = [
              'status' => $type,
              'amount' => $event_filter['data']['attributes']['data']['attributes']['amount'] ?? 0,
              'currency' => $event_filter['data']['attributes']['data']['attributes']['currency'] ?? 'unknown',
              'payment_method' => $event_filter['data']['attributes']['data']['attributes']['payment_method_details']['type'] ?? 'unknown',
              'payment_id' => $event_filter['data']['id'] ?? 'unknown',
              'metadata' => $event_filter['data']['attributes']['data']['attributes']['metadata'] ?? [],
            ];
            dd($paymentData);
            // WebhookModel::insert([
            //     'payload' => $type,
            // ]);
        } else {
            // WebhookModel::insert([
            //     'payload' => 'invalid',
            // ]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        return response()->json(['status' => 'ok']);
    }
}
