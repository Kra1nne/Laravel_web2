<?php

namespace App\Http\Controllers\Account;

use App\Models\Log;
use App\Models\User;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index(){
      $users = User::leftjoin('person', 'person.id', 'users.person_id')->orderBy('users.id', 'DESC')->whereNull('users.deleted_at')->get();
      return view('content.accounts.users', compact('users'));
    }
    public function store(Request $request){

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
      'role' => $request->role,
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
      return response()->json(['Error' => 0, 'Message' => 'Successfully added a data']);
    }
  }
  public function update(Request $request){
    $id =  Crypt::decryptString($request->id);
    $user = [
      'email' => $request->email,
      'role' => $request->role,
    ];

     $person = [
      'firstname' => $request->firstname,
      'middlename' => $request->middlename,
      'lastname' => $request->lastname,
      'created_at' => now()
    ];

    $userData = User::where('id', $id)->update($user);
    $personData = Person::where('id', $id)->update($person);

    $log = [
      'user_id' =>  $id, //Auth::id()
      'action' => 'Update',
      'table_name' => 'Users',
      'description' => 'Update a account',
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $logData = Log::insert($log);

    if($logData){
      return response()->json(['Error' => 0, 'Message' => 'Successfully update a data']);
    }
  }
  public function delete(Request $request){

    $id = Crypt::decryptString($request->id);

    $user = [
      'deleted_at' => now()
    ];

    $person = [
      'deleted_at' => now()
    ];

    $userData = User::where('id', $id)->update($user);
    $personData = Person::where('id', $id)->update($person);


    $log = [
      'user_id' =>  $id, //Auth::id()
      'action' => 'Update',
      'table_name' => 'Users',
      'description' => 'Update a account',
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $logData = Log::insert($log);

    if($logData){
      return response()->json(['Error' => 0, 'Message' => 'Successfully delete a data']);
    }
  }
  public function logs(){
    $logs = Log::leftjoin('users', 'logs.user_id', 'users.id')
      ->leftjoin('person', 'users.person_id', 'person.id')
      ->select('logs.*', 'person.firstname', 'person.middlename', 'person.lastname', 'users.email')
      ->orderBy('logs.id', 'DESC')
      ->get();
      
    return view('content.logs.logs', compact('logs'));
  }
}
