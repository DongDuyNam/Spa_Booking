<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'full_name' => $validated['full_name'],
        'email' => $validated['email'],
        'password_hash' => Hash::make($validated['password']),
        'role_id' => 3,
    ]);

    \App\Models\Customer::create([
        'user_id' => $user->user_id,
        'loyalty_points' => 0,
        'total_spent' => 0,
    ]);

    Auth::login($user);

    return redirect()->route('home');
}

}
