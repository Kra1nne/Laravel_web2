<?php

namespace App\Http\Controllers\reservation;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Log;
use App\Models\Rating;
use App\Models\Facility;
use App\Models\Payment;

class ReservationController extends Controller
{
    public function index(){
      $facilities = Facility::leftjoin('promos','facilities.id', '=', 'promos.facilities_id')
                      ->whereNull('facilities.deleted_at')
                       ->select(
                            'facilities.id as facility_id',
                            'facilities.name as facility_name',
                            'promos.id as promo_id',
                            'promos.name as promo_name'
                        )
                      ->get();
      
      $reservations = Booking::with('foods')
                    ->leftjoin('facilities', 'facilities.id', '=', 'bookings.facilities_id')
                    ->leftjoin('users', 'users.id', '=', 'bookings.users_id')
                    ->leftjoin('payments', 'payments.bookings_id', '=', 'bookings.id')
                    ->leftjoin('person', 'person.id', '=', 'users.person_id')
                    ->leftjoin('rating', 'rating.bookings_id', '=', 'bookings.id')
                    ->leftJoin('promos', function($join) {
                        $join->on('promos.facilities_id', '=', 'facilities.id')
                            ->whereColumn('promos.id', 'bookings.promos_id');
                    })
                    ->orderBy('bookings.created_at', 'DESC')
                    ->distinct('bookings.id')
                    ->select('bookings.*', 'facilities.name as facilities_name', 'promos.name as promos_name', 'promos.price as promos_price', 'facilities.price as facilities_price','person.firstname', 'person.middlename', 'person.lastname', 'rating.rating as rate', 'payments.amount as payment_amount', 'payments.id as payment_id')
                    ->get()->map(function ($reservation) {
                          $reservation->encrypted_id = Crypt::encryptString($reservation->id);
                          return $reservation;
                      });

      return view('content.reservation.reservation-list', compact('reservations', 'facilities'));
    }

    public function userReservationDisplay(){
       $reservations = Booking::with('foods')
                    ->leftjoin('facilities', 'facilities.id', '=', 'bookings.facilities_id')
                    ->leftjoin('users', 'users.id', '=', 'bookings.users_id')
                    ->leftjoin('payments', 'payments.bookings_id', '=', 'bookings.id')
                    ->leftjoin('person', 'person.id', '=', 'users.person_id')
                    ->leftjoin('rating', 'rating.bookings_id', '=', 'bookings.id')
                    ->leftJoin('promos', function($join) {
                        $join->on('promos.facilities_id', '=', 'facilities.id')
                            ->whereColumn('promos.id', 'bookings.promos_id');
                    })
                    ->orderBy('bookings.created_at', 'DESC')
                    ->where('users.id', '=', Auth::id())
                    ->distinct('bookings.id')
                    ->select('bookings.*', 'facilities.name as facilities_name', 'promos.name as promos_name', 'promos.price as promos_price', 'facilities.price as facilities_price','person.firstname', 'person.middlename', 'person.lastname', 'rating.rating as rate', 'payments.amount as payment_amount', 'payments.id as payment_id', 'facilities.category as fac_category')
                    ->get()->map(function ($reservation) {
                          $reservation->encrypted_id = Crypt::encryptString($reservation->id);
                          return $reservation;
                      });

      return view('content.reservation.user_reservation-list', compact('reservations'));
    }
    public function rating(Request $request){
      $data = [
        'rating' => $request->rating,
        'comments' => $request->description,
        'bookings_id' => $request->bookings_id,
        'facilities_id' => $request->facilities_id,
        'created_at' => now()
      ];
      $rating = Rating::insert($data);
      $logData = [
        'user_id' => Auth::id(),
        'action' => 'Add',
        'table_name' => 'Rating',
        'description' => 'Added a Comments',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::insert($logData);
      
      if($rating){
        return response()->json(['Error' => 0, 'Message' => 'Successfully added a Rating']);
      }
    }

    public function done(Request $request)
    {
      $bookingsData = [
        'status' => "Fully Paid",
        'updated_at' => now()
      ];
      Booking::where('id', $request->id)->update($bookingsData);
       $logData = [
        'user_id' => Auth::id(),
        'action' => 'Update',
        'table_name' => 'Bookings',
        'description' => 'Update a Status',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      Log::insert($logData);

      $paymentData = [
        'status' => "Fully Paid",
        'updated_at' => now(),
        'amount' => ($request->amount + $request->amount)
      ];

      Payment::where('id', $request->payment_id)->update($paymentData);
      $logData = [
        'user_id' => Auth::id(),
        'action' => 'Update',
        'table_name' => 'Payment',
        'description' => 'Update a Payment',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::insert($logData);

      if($resultLogs){
        return response()->json(['Error' => 0, 'Message' => 'Reservation payment successfully done.']);
      }
    }
    public function cancel(Request $request)
    {
      $bookingsData = [
        'status' => "Cancel",
        'updated_at' => now()
      ];
      Booking::where('id', $request->id)->update($bookingsData);
       $logData = [
        'user_id' => Auth::id(),
        'action' => 'Update',
        'table_name' => 'Bookings',
        'description' => 'Update a Status',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      Log::insert($logData);

      $paymentData = [
        'status' => "Cancel",
        'updated_at' => now(),
      ];

      Payment::where('id', $request->payment_id)->update($paymentData);
      $logData = [
        'user_id' => Auth::id(),
        'action' => 'Update',
        'table_name' => 'Payment',
        'description' => 'Update a Payment',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::insert($logData);

      if($resultLogs){
        return response()->json(['Error' => 0, 'Message' => 'Successfully cancel your reservation.']);
      }
    }
    public function updateReservation(Request $request)
    {
      $checkIn = $request->checkin;
      $checkOut = $request->checkout;
      $bookings = Booking::whereNotIn('status', ['Cancel', 'Full Paid'])
            ->where('facilities_id', $request->facilityId)
            ->select('check_in', 'check_out')
            ->get();

        // Check for overlap
      $occupied = $bookings->contains(function ($booking) use ($checkIn, $checkOut) {
          return !(
              $checkOut <= $booking->check_in ||  // new checkout is before existing check-in
              $checkIn >= $booking->check_out     // new check-in is after existing checkout
          );
      });

      if ($occupied) {
          return response()->json(['Error' => 1, 'Message' => 'Selected dates are already booked for this facility.']);
      }
      $data = [
        'check_in' => $checkIn,
        'check_out' => $checkOut,
      ];
      Booking::where('id', $request->id)->update($data);

      $logData = [
        'user_id' => Auth::id(),
        'action' => 'Update',
        'table_name' => 'Booking',
        'description' => 'Update a Booking',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::insert($logData);

      return response()->json(['Error' => 0, 'Message' => 'Successfully update your reservation.']);
    }
}
