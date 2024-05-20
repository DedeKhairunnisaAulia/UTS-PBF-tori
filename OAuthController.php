<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class oauthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        
        // Check if user already exists
        $existingUser = User::where('email', $user->email)->first();
        
        if ($existingUser) {
            // User already exists, log in the user
            // Implement your login logic here
        } else {
            // User doesn't exist, register the user
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            // Other fields as per your user schema
            $newUser->save();
            
            // Log in the newly registered user
            // Implement your login logic here
        }
        
        // Redirect the user after login/registration
        // Implement your redirect logic here
    }
}
