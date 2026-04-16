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
    public function create(Request $request): View
    {
        $role = $request->query('role', 'nursery_owner');

        if ($role === 'user') {
            return view('auth.register-user');
        }

        $cities = City::orderBy('name')->get();
        return view('auth.register', [
            'cities' => $cities,
            'role'   => $role,
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $role = $request->input('role', 'nursery_owner');

        $commonRules = [
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms'    => ['accepted'],
        ];

        if ($role === 'user') {
            $request->validate(array_merge($commonRules, [
                'name' => ['required', 'string', 'max:255'],
            ]));

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => User::ROLE_USER,
            ]);
        } else {
            $request->validate(array_merge($commonRules, [
                'nursery_name' => ['required', 'string', 'max:255'],
                'city_id'      => ['required', 'integer', 'exists:cities,id'],
                'phone'        => ['required', 'string', 'max:30'],
                'address'      => ['required', 'string', 'max:500'],
            ]));

            $user = User::create([
                'name'     => $request->nursery_name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => User::ROLE_NURSERY_OWNER,
            ]);

            Nursery::create([
                'owner_id' => $user->id,
                'name'     => $request->nursery_name,
                'city_id'  => $request->city_id,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'status'   => 'pending',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

