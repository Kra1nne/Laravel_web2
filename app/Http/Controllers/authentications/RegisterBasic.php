<?php

namespace App\Http\Controllers\authentications;

use App\Models\Log;
use App\Models\User;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }
  public function store(Request $request){

    $duplicate = User::where('email','=', $request->email)->first();
    if($duplicate){
      return response()->json(['Error' => 1, 'Message' => 'Invalid Email Already been use.']);
    }
    $person = [
      'firstname' => $request->firstname,
      'middlename' => $request->middlename,
      'lastname' => $request->lastname,
      'created_at' => now()
    ];

    $personData = Person::create($person);
    $user = [
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'role' => 'User',
      'created_at' => now(),
      'person_id' => $personData->id
    ];

    $userData = User::create($user);
    $log = [
      'user_id' => $userData->id,
      'action' => 'Add',
      'table_name' => 'Users',
      'description' => 'Added a account',
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $logData = Log::insert($log);

    if($logData){
      return response()->json(['Error' => 0, 'Message' => 'Successfully created a Account', 'Redirect' => route('login')]);
    }
  }
}
