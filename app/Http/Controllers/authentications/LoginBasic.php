<?php

namespace App\Http\Controllers\authentications;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }
  public function login(Request $request){
    $account = User::where('email', $request->email_username)->whereNull('deleted_at')->first();

    if (!$account || !Hash::check($request->password, $account->password)) {
        $message = $account ? 'Invalid Email or Password.' : 'Account didn\'t exist.';
        return response()->json(['Error' => 1, 'Message' => $message]);
    }

    $logData = [
      'user_id' => $account->id,
      'action' => 'Login',
      'table_name' => 'Users',
      'description' => 'Successfully login',
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $resultLogs = Log::insert($logData);
    Auth::login($account);

    if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Employee'){
      return response()->json(['Error' => 0, 'Message' => 'Successfully login', 'Redirect' => route('dashboard-analytics')]);
    }
    if(Auth::user()->role == 'User'){
      return response()->json(['Error' => 0, 'Message' => 'Successfully login', 'Redirect' => route('home')]);
    }
  }
  public function logoutAccount(Request $request)
  {
    $account = User::where('id', Auth::id())->first();
    $logData = [
      'user_id' => Auth::id(),
      'action' => 'Logout',
      'table_name' => 'Users',
      'description' => 'Successfully logout',
      'ip_address' => request()->ip(),
      'created_at' => now(),
    ];

    $resultLogs = Log::insert($logData);
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }
}
