<?php

namespace App\Http\Controllers\home;

use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PricingController extends Controller
{
    public function index(){
      $rooms = Facility::with('picture', 'promo')
        ->where('category', 'room')
        ->whereNull('deleted_at')
        ->get();

      $cottages = Facility::with('picture')
        ->where('category', 'cottage')
        ->whereNull('deleted_at')
        ->get()
        ->groupBy(function ($item) {
            return preg_replace('/\s*\d+$/', '', $item->name);
        })
        ->map(function ($group) {
            return $group->first();
        });

      return view('content.pricing.pricing', compact('rooms', 'cottages'));
    }
}
