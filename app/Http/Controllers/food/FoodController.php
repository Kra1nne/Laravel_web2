<?php

namespace App\Http\Controllers\food;

use App\Models\Log;
use App\Models\Food;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('picture')
            ->orderBy('created_at', 'Desc')
            ->whereNull('deleted_at')
            ->get();

        return view('content.food.food-list', compact('foods'));
    }
    public function display()
    {
        $foods = Food::with('picture')
            ->whereNull('deleted_at')
            ->get();

        return view('content.food.food-display', compact('foods'));
    }
    public function store(Request $request)
    {
      $logData = [
        'user_id' => Auth::id(),
        'action' => 'Add',
        'table_name' => 'Foods',
        'description' => 'Added a food',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::insert($logData);

      $food = Food::create([
          'name' => $request->name,
          'price' => $request->price,
          'category' => $request->category,
          'description' => $request->description,
          'created_at' => now(),
          'updated_at' => now(),
          'users_id' => Auth::id(),
      ]);

      if ($request->hasFile('imagesData')) {
        $image = $request->file('imagesData');
        $path = $image->store('public/uploads');
        Picture::create([
            'path' => Storage::url($path),
            'foods_id' => $food->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
      }

      return response()->json(['Error' => 0, 'Message' => 'Successfully added a data']);
    }
    public function delete(Request $request){

      $logData = [
        'user_id' => Auth::id(),
        'action' => 'Delete',
        'table_name' => 'Foods',
        'description' => 'Delete a food',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::insert($logData);

      $food = [
        'deleted_at' => now()
      ];

      $result = Food::where('id', Crypt::decryptString($request->id))->update($food);
      $photoImages = Picture::where('foods_id', Crypt::decryptString($request->id))->first();
      $filePath = str_replace('storage/', 'public/', $photoImages->path);

      Storage::delete($filePath);
      Picture::where('foods_id', Crypt::decryptString($request->id))->delete();

      if($result){
        return response()->json(['Error' => 0, 'Message' => 'Successfully delete a data']);
      }
    }
    public function update(Request $request)
    {
      $logData = [
        'user_id' => Auth::id(),
        'action' => 'Update',
        'table_name' => 'Foods',
        'description' => 'Update a food',
        'ip_address' => request()->ip(),
        'created_at' => now(),
      ];

      $resultLogs = Log::insert($logData);

      $food = [
          'name' => $request->name,
          'price' => $request->price,
          'category' => $request->category,
          'description' => $request->description,
          'updated_at' => now(),
      ];

      $result = Food::where('id', Crypt::decryptString($request->id))->update($food);

      if($request->hasFile('imagesData')){
          $image = $request->file('imagesData');
          $path = $image->store('public/uploads');
          $newPicture = Picture::create([
              'path' => Storage::url($path),
              'foods_id' => Crypt::decryptString($request->id),
              'created_at' => now(),
              'updated_at' => now(),
          ]);

          $photoImages = Picture::where('foods_id', Crypt::decryptString($request->id))
              ->where('id', '!=', $newPicture->id)
              ->first();
          if ($photoImages) {
              $filePath = str_replace('storage/', 'public/', $photoImages->path);
              Storage::delete($filePath);
              $photoImages->delete();
          }
      }


      if($result){
        return response()->json(['Error' => 0, 'Message' => 'Successfully update a data']);
      }
    }
}
