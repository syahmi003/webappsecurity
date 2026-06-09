<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration logic
    public function register(Request $request)
    {
        // 1. INPUT VALIDATION — strict rules including strong password policy
        $request->validate([
            'name'     => 'required|string|max:255|regex:/^[\pL\s\-]+$/u', // letters, spaces, hyphens only
            'email'    => 'required|string|email|max:255|unique:users,email',
            // 2. AUTHENTICATION — enforce strong password: min 8 chars, mixed case, number, symbol
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), // checks against known breached password lists
            ],
        ]);

        // 3. AUTHENTICATION — always hash passwords, never store plain text
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 4. SESSION FIXATION prevention — regenerate session after login
        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
