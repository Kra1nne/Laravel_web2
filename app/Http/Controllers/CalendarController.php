<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class CalendarController extends Controller
{
    public function index(){
        $reservations = Booking::leftjoin('facilities', 'facilities.id', '=', 'bookings.facilities_id')
                    ->leftjoin('payments', 'payments.bookings_id', '=', 'bookings.id')
                    ->where('payments.status', '!=' , 'Cancel')
                    ->get();
        
        return view('content.calendar.calendar', compact('reservations'));
    }
}
