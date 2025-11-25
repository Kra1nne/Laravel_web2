<?php

namespace App\Http\Controllers\promos;

use App\Models\Log;
use App\Models\Promo;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PromosController extends Controller
{
    public function index() {

      $promos = Promo::leftjoin('facilities', 'promos.facilities_id', '=', 'facilities.id')
        ->select('promos.*', 'facilities.name as facility_name')
        ->whereNull('promos.deleted_at')
        ->get();
      $facilities = Facility::whereNull('deleted_at')->get();
      return view('content.promo.promos', compact('promos', 'facilities'));
    }
    public function store(Request $request) {

      $logData = Log::insert([
        'user_id' => Auth::id(),
        'action' => 'Add',
        'table_name' => 'Promos',
        'description' => 'Added a new promos',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ]);

      // Store the promo data
      Promo::create([
          'name' => $request->name,
          'price' => $request->price,
          'additional_price' => $request->additional_price,
          'max_person' => $request->max_person,
          'description' => $request->description,
          'facilities_id' => $request->facilities_id,
          'created_at' => now(),
          'updated_at' => now(),
      ]);

      return response()->json(['Error' => 0,'Message' => 'Promo added successfully']);
    }

    public function update(Request $request) {
      $id = Crypt::decryptString($request->id);
      $promo = Promo::find($id);
      if (!$promo) {
          return response()->json(['Error' => 1, 'Message' => 'Promo not found']);
      }

      $logData = Log::insert([
        'user_id' => Auth::id(),
        'action' => 'Update',
        'table_name' => 'Promos',
        'description' => 'Updated a promo',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ]);

      $promo->update([
          'name' => $request->name,
          'price' => $request->price,
          'additional_price' => $request->additional_price,
          'max_person' => $request->max_person,
          'description' => $request->description,
          'facilities_id' => $request->facilities_id,
          'updated_at' => now(),
      ]);

      return response()->json(['Error' => 0, 'Message' => 'Promo updated successfully']);
    }

    public function delete(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        $promo = Promo::find($id);
        if (!$promo) {
            return response()->json(['Error' => 1, 'Message' => 'Promo not found']);
        }

        $logData = Log::insert([
            'user_id' => Auth::id(),
            'action' => 'Delete',
            'table_name' => 'Promos',
            'description' => 'Deleted a promo',
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);

        $promo->delete();

        return response()->json(['Error' => 0, 'Message' => 'Promo deleted successfully']);
    }
}
