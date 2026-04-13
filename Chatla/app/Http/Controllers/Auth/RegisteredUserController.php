<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Nursery;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $cities = City::orderBy('name')->get();
        return view('auth.register', [
            'cities' => $cities,
            'role'   => $request->query('role', 'nursery_owner'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // ── User fields ──────────────────────────────────────────
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'     => ['required', Rules\Password::defaults()],
            'terms'        => ['accepted'],

            // ── Nursery fields ───────────────────────────────────────
            'nursery_name' => ['required', 'string', 'max:255'],
            'city_id'      => ['required', 'integer', 'exists:cities,id'],
            'phone'        => ['required', 'string', 'max:30'],
            'address'      => ['required', 'string', 'max:500'],
        ]);

        // BUG 3 fix: form has no 'name' field — derive it from nursery_name
        // BUG 3 fix: form has no 'role' field — hard-code it as nursery_owner
        $user = User::create([
            'name'     => $request->nursery_name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => User::ROLE_NURSERY_OWNER,
        ]);

        // BUG 4 fix: Nursery record was never created — create it now
        Nursery::create([
            'owner_id' => $user->id,
            'name'     => $request->nursery_name,
            'city_id'  => $request->city_id,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'status'   => 'pending',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

