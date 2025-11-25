<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Booking;

class ReportControllers extends Controller
{
    public function index(){
        return view('content.reports.reports');
    }
    public function generate(Request $request){

        if($request->from_date > now() || $request->to_date > now()){
           return redirect()->route('reports-page')->with('show_modal', true);
        }

        if($request->to_date && $request->from && $request->to_date < $request->from){
           return redirect()->route('reports-page')->with('show_modal_2', true);
        }


        $bookings = Booking::leftjoin('payments', 'payments.bookings_id', '=', 'bookings.id')
                ->whereDate('bookings.check_in', '<=', $request->to_date)
                ->whereDate('bookings.check_out', '>=', $request->from_date)
                ->select('payments.*')
                ->get();
       
        $sumAmount = $bookings->sum('amount');  
        
        $pdf = Pdf::loadView('pdf.revenue', [
        'Revenue' => $bookings,
        'Total' => $sumAmount
      ]);
      $pdf->setpaper('A4', 'portrait');
      return $pdf->stream('revenue.pdf');
    }
}
