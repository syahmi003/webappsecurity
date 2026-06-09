<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // 1. INPUT VALIDATION — enforce proper format on both fields
        $request->validate([
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // 2. AUTHENTICATION — rate limiting (max 5 attempts per minute per email+IP)
        $throttleKey = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        // 3. AUTHENTICATION — attempt login with hashed password check via Auth
        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->boolean('remember')   // honour "remember me" checkbox
        )) {
            // 4. SESSION FIXATION prevention — regenerate session on login
            $request->session()->regenerate();

            RateLimiter::clear($throttleKey);

            return redirect()->intended(route('home'));
        }

        // Increment failed attempts counter
        RateLimiter::hit($throttleKey);

        // Return generic error — do not reveal whether email or password was wrong
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        // 5. SESSION SECURITY — invalidate session and regenerate CSRF token on logout
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
