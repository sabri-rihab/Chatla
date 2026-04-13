<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\City;

class NurseryProfileController extends Controller
{
    public function edit(Request $request)
    {
        $cities = City::orderBy('name')->get();
        return view('nursery.profile', compact('cities'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'city_id'         => ['required', 'exists:cities,id'],
            'address'         => ['required', 'string', 'max:500'],
            'website'         => ['nullable', 'url', 'max:255'],
            'phone'           => ['required', 'string', 'max:30'],
            'email'           => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($request->user()->id)],
            'owner_name'      => ['required', 'string', 'max:255'],
            'operating_hours' => ['nullable', 'string', 'max:1000'],
            'profile_img'     => ['nullable', 'image', 'max:2048'],
            'owner_profile_img' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = $request->user();
        $nursery = $request->attributes->get('nursery');

        // Update User info
        $userData = [
            'name'  => $request->owner_name,
            'email' => $request->email,
        ];

        // Handle owner profile image upload
        if ($request->hasFile('owner_profile_img')) {
            if ($user->profile_img) {
                Storage::disk('public')->delete($user->profile_img);
            }
            $userData['profile_img'] = $request->file('owner_profile_img')->store('owners', 'public');
        }

        $user->update($userData);

        // Update Nursery info
        $nurseryData = [
            'name'            => $request->name,
            'city_id'         => $request->city_id,
            'address'         => $request->address,
            'website'         => $request->website,
            'phone'           => $request->phone,
            'operating_hours' => $request->operating_hours,
        ];

        // Handle image upload with the correct profile_img schema name
        if ($request->hasFile('profile_img')) {
            if ($nursery->profile_img) {
                Storage::disk('public')->delete($nursery->profile_img);
            }
            $path = $request->file('profile_img')->store('nurseries', 'public');
            $nurseryData['profile_img'] = $path;
        }

        $nursery->update($nurseryData);

        return redirect()->route('nursery.profile.edit')->with('status', 'profile-updated');
    }
}
