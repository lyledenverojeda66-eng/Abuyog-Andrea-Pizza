<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REGISTER PAGE
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('register');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
        ]);

        // Create customer account.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        // Automatically log in the customer.
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('customer.dashboard')
            ->with(
                'success',
                'Your account has been created successfully!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        // Validate login credentials.
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],
        ]);

        // Check email and password.
        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'The email or password is incorrect.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | SUSPENDED CUSTOMER ACCOUNT
        |--------------------------------------------------------------------------
        */

        if (
            $user->role === 'customer' &&
            !is_null($user->banned_at)
        ) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account has been suspended due to repeated inappropriate language in feedback. Please contact the administrator for assistance.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }

        // Regenerate session after successful login.
        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with(
                    'success',
                    'Welcome to Admin Dashboard!'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | RIDER
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'rider') {
            return redirect()
                ->route('rider.dashboard')
                ->with(
                    'success',
                    'Welcome to Rider Dashboard!'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | STAFF
        |--------------------------------------------------------------------------
if ($user->role === 'staff') {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()
        ->route('login')
        ->withErrors([
            'email' => 'The staff dashboard is not configured yet. Please contact the administrator.',
        ]);
}
        /*
        |--------------------------------------------------------------------------
        | CUSTOMER
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'customer') {
            return redirect()
                ->route('customer.dashboard')
                ->with(
                    'success',
                    'Welcome back!'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | UNKNOWN ROLE
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Your account role is not recognized.',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        // Log out the current user.
        Auth::logout();

        // Invalidate the current session.
        $request->session()->invalidate();

        // Regenerate the CSRF token.
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'You have been logged out.'
            );
    }
}
