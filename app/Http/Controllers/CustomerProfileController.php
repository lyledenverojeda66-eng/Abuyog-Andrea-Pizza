<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerProfileController extends Controller
{
    /**
     * Display the customer's profile.
     */
    public function edit()
    {
        return view('customer.profile', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update the customer's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        unset($validated['profile_picture']);

        if ($request->hasFile('profile_picture')) {
            $oldPicture = $user->profile_picture;

            $validated['profile_picture'] = $request
                ->file('profile_picture')
                ->store('profile-pictures', 'public');

            if ($oldPicture) {
                Storage::disk('public')->delete($oldPicture);
            }
        }

        $user->update($validated);

        return redirect()
            ->route('customer.profile')
            ->with('success', 'Profile updated successfully!');
    }
}