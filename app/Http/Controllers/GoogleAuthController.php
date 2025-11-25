<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Log;
use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        try {
            // Get the user information from Google
            $user = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $fullName = $user->name;
            $firstName = $user->user['given_name'] ?? null;
            $lastName = $user->user['family_name'] ?? null;
            $middleName = null;

            $nameParts = explode(' ', $fullName);
            if (count($nameParts) > 2) {
                $middleName = implode(' ', array_slice($nameParts, 1, -1));
            }

            $person = [
                'firstname'  => $firstName,
                'middlename' => $middleName,
                'lastname'   => $lastName,
                'created_at' => now(),
            ];

            $personData = Person::create($person);

            $newUser = User::updateOrCreate([
                'email' => $user->email
            ], [
                'password' => bcrypt(Str::random(16)), 
                'role' => "User",
                'created_at' => now(),
                'person_id' => $personData->id
            ]);

            Auth::login($newUser);
        }

        $logData = [
            'action' => 'Login',
            'table_name' => 'Users',
            'description' => 'Successfully login',
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ];

        $resultLogs = Log::insert($logData);

        if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Employee'){
            return redirect('/dashboard');
        }
        if(Auth::user()->role == 'User'){
            return redirect('/');
        }

    }
}
