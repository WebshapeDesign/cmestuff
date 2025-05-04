<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePreferencesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function profile()
    {
        return view('settings.profile');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            // Store new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('settings.profile')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePreferences(UpdatePreferencesRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());

        return redirect()->route('settings.profile')
            ->with('success', 'Preferences updated successfully.');
    }
} 