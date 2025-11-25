<?php

namespace App\Http\Controllers\payment;

use App\Models\Food;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\FoodBooking;
use Illuminate\Http\Request;
use Luigel\Paymongo\Paymongo;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Facility;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        // Store booking data temporarily
        session(['payment_data' => $request->all()]);

        $amount = (int) ($request->input('total_amount') * 100 / 2); 
        $facilityName = Facility::where('id', $request->facility_id)->first();
        $name = $facilityName->name ?? "Cottages/Rooms";

        // Create Checkout Session
        $session = $this->createCheckoutSession($amount, $name);

        if ($session["status"] === "timeout" || $session["status"] === "error") {
            return back()->with('payment_error', $session["message"]);
        }

        return redirect()->away($session["url"]);
    }
    private function createCheckoutSession($amount, $name)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paymongo.com/v1/checkout_sessions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_TIMEOUT => 8,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/json",
                "authorization: Basic " . base64_encode(config('services.paymongo.secret'))
            ],
            CURLOPT_POSTFIELDS => json_encode([
                "data" => [
                    "attributes" => [
                        "line_items" => [
                            [
                                "currency" => "PHP",
                                "amount" => $amount,
                                "description" => "Blue Oasis Booking Payment",
                                "name" => $name,
                                "quantity" => 1
                            ]
                        ],
                        "payment_method_types" => ["gcash"],
                        "send_email_receipt" => false,
                        "show_description" => true,
                        "show_line_items" => true,
                        "description" => "Blue Oasis Partial Payment",
                        "success_url" => route('payment.success'),
                        "cancel_url" => route('booking'),
                    ]
                ]
            ]),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl); 
        curl_close($curl);

        if ($err) {
            return [
                "status" => "timeout",
                "message" => "Payment gateway is slow or not responding."
            ];
        }

        $decoded = json_decode($response, true);

        if (!isset($decoded["data"]["attributes"]["checkout_url"])) {
            return [
                "status" => "error",
                "message" => "Unable to generate checkout URL."
            ];
        }

        return [
            "status" => "ok",
            "url" => $decoded["data"]["attributes"]["checkout_url"]
        ];
    }
    public function paymentSuccess(Request $request)
    {
        $data = session('payment_data');

        $booking = [
            'reserve' => 1,
            'walk_in' => 0,
            'status' => 'Partial Payment',
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'created_at' => now(),
            'users_id' => Auth::id(),
            'promos_id' => $data['promo_id'] ?? null,
            'amount' => $data['total_amount'],
            'facilities_id' => $data['facility_id'],
            'guest' => $data['guest_count'],
            'facility_income' => $data['facility_income'],
        ];
        $bookingID = Booking::create($booking);

        $foodIDs = $data['food_id'] ?? [];
        $foodQuantities = $data['food_quantity'] ?? [];

        if (is_string($foodIDs)) {
            $foodIDs = explode(',', $foodIDs);
        }
        if (is_string($foodQuantities)) {
            $foodQuantities = explode(',', $foodQuantities);
        }

        foreach ($foodIDs as $index => $id) {
            FoodBooking::insert([
                'bookings_id' => $bookingID->id,
                'foods_id' => $id,
                'quantity' => $foodQuantities[$index] ?? 1,
                'created_at' => now(),
            ]);
        }

        $payment = [
            'status' => 'Partial Payment',
            'amount' => $data['total_amount'] / 2,
            'created_at' => now(),
            'bookings_id' => $bookingID->id,
        ];
        Payment::insert($payment);

        session()->forget('payment_data');
        return redirect()->route('booking')->with('show_modal', true)->with('booking_id', Crypt::encryptString($bookingID->id));
    }

    public function paymentFailed(Request $request)
    {
        return view('payment.failed');
    }

    public function displayPDF(Request $request) {
        $Id = $request->query('booking');
        $bookingId = Crypt::decryptString($Id);

        $booking = Booking::leftjoin('facilities', 'bookings.facilities_id', '=', 'facilities.id')
            ->leftjoin('promos', 'bookings.promos_id', '=', 'promos.id')
            ->where('bookings.id', $bookingId)
            ->select('bookings.*', 'facilities.name as facility_name', 'facilities.price as facility_price', 'promos.*')
            ->first();

        $food = Food::leftjoin('food_bookings', 'foods.id', '=', 'food_bookings.foods_id')
            ->leftjoin('bookings', 'food_bookings.bookings_id', '=', 'bookings.id')
            ->where('bookings.id', $bookingId)
            ->get();

        $bookingDetails = [
            'name' => $booking->name ?? $booking->facility_name,
            'price' => $booking->price ?? $booking->facility_price,
            'check_in' => $booking->check_in,
            'check_out' => $booking->check_out,
            'date' => now(),
            'promo' => $booking->name,
            'status' => $booking->status,
            'service_fee' => 50,
            'total_amount' => $booking->amount,
        ];

        $foodItems = [];
        foreach( $food as $item ){
            $foodItems[] = [
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
            ];
        }

        $pdf = Pdf::loadView('pdf.bookingPDF', [
            'Details' => $bookingDetails,
            'Foods' => $foodItems,
        ]);
        $pdf->setpaper('A6', 'portrait');
        return $pdf->stream('reciept.pdf');
    }

    public function paymentSuccessAdmin(Request $request)
    {
        $booking = [
            'reserve' => 1,
            'walk_in' => 1,
            'status' => 'Partial Payment',
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'created_at' => now(),
            'users_id' => Auth::id(),
            'promos_id' => $request->promo_id ?? null,
            'amount' => $request->total_amount,
            'facilities_id' => $request->facility_id,
            'guest' => $request->guest_count,
            'facility_income' => $request->facility_income,
            'name' => $request->name
        ];
        $bookingID = Booking::create($booking);

        $foodIDs = $request->food_id ?? [];
        $foodQuantities = $request->food_quantity ?? [];

        if (is_string($foodIDs)) {
            $foodIDs = explode(',', $foodIDs);
        }
        if (is_string($foodQuantities)) {
            $foodQuantities = explode(',', $foodQuantities);
        }

        foreach ($foodIDs as $index => $id) {
            FoodBooking::insert([
                'bookings_id' => $bookingID->id,
                'foods_id' => $id,
                'quantity' => $foodQuantities[$index] ?? 1,
                'created_at' => now(),
            ]);
        }

        $payment = [
            'status' => 'Partial Payment',
            'amount' => $request->total_amount / 2,
            'created_at' => now(),
            'bookings_id' => $bookingID->id,
        ];
        Payment::insert($payment);

        return redirect()->route('product-facilities')->with('show_modal', true)->with('booking_id', Crypt::encryptString($bookingID->id));
    }
    // public function checkout(Request $request)
    // {
    //     $amount = (int) ($request->input('total_amount')); 
    //     $paymongo = new Paymongo(config('services.paymongo.secret'));
    //     $data = $request->all();

    //     session(['payment_data' => $data]);

    //     $paymentIntent = $paymongo->paymentIntent()->create([
    //         'amount' => $amount / 2,
    //         'payment_method_allowed' => ['gcash', 'card', 'grab_pay', 'paymaya'],
    //         'currency' => 'PHP',
    //         'description' => 'Booking Payment',
    //     ]);

    //     $paymentMethod = $paymongo->paymentMethod()->create([
    //         'type' => 'gcash',
    //         'details' => [
    //             'redirect' => [
    //                 'success' => route('payment.success'),
    //                 'failed' => route('booking'),
    //             ],
    //         ],
    //     ]);


    //     $attached = $paymongo->paymentIntent()->attach(
    //         $paymentIntent,
    //         $paymentMethod->id,
    //         route('payment.success')
    //     );


    //     if ($attached->next_action && isset($attached->next_action['redirect']['url'])) {
    //         return redirect($attached->next_action['redirect']['url']);
    //     } else {
    //         return back()->with('error', 'Unable to initiate payment. Please try again.');
    //     }
    // }
    // public function createCheckoutSession()
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, [
    //         CURLOPT_URL => "https://api.paymongo.com/v1/checkout_sessions",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_HTTPHEADER => [
    //             "accept: application/json",
    //             "content-type: application/json",
    //             "authorization: Basic c2tfdGVzdF9ldWFwbTJwdkNNQm0yVzQ3Q1VRbWhlR0g6"
    //         ],
    //         CURLOPT_POSTFIELDS => json_encode([
    //             "data" => [
    //                 "attributes" => [
    //                     "line_items" => [
    //                         [
    //                             "currency" => "PHP",
    //                             "amount" => 121131, 
    //                             "description" => "BlueOasis Payment",
    //                             "name" => "BlueOasis", 
    //                             "quantity" => 1
    //                         ]
    //                     ],
    //                     "payment_method_types" => ["gcash"],
    //                     "send_email_receipt" => false,
    //                     "show_description" => true,
    //                     "show_line_items" => true,
    //                     "description" => "dada"
    //                 ]
    //             ]
    //         ]),
    //     ]);

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);
    //     curl_close($curl);

    //     if ($err) {
    //         return "cURL Error #:" . $err;
    //     }

    //     $decoded = json_decode($response, true);

    //     $checkoutUrl = $decoded["data"]["attributes"]["checkout_url"] ?? null;

    //     return $checkoutUrl; 
    // }
    
}
