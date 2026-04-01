<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the combined login / register page.
     * The $activeTab variable determines which panel is open by default.
     */
    public function showLogin()
    {
        return view('auth.login', ['activeTab' => 'login']);
    }

    /**
     * Show the register tab (same view, different default tab).
     */
    public function showRegister()
    {
        return view('auth.login', ['activeTab' => 'register']);
    }

    /**
     * Handle the login form submission.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [], [], 'login');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()
            ->withErrors([
                'email' => __('auth.failed'),
            ], 'login')
            ->withInput($request->only('email'))
            ->with('activeTab', 'login');
    }

    /**
     * Handle the register form submission.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'string', 'min:8', 'confirmed']
        ], [
            'terms.accepted' => 'You must accept the Terms of Service and Privacy Policy.',
        ], [], 'register');

        $user = User::create([
            'name'     => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
