<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'profile' => $request->user()->profile
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'        => 'nullable|string|max:255',
            'email'       => 'nullable|email|unique:users,email,' . ($request->user()->id ?? 'NULL'),
            'password'    => 'nullable|min:6',
            'description' => 'nullable|string',
            'address'     => 'nullable|string',
            'phone'       => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'remove_photo'=> 'nullable',
        ]);

        try {
            $user = $request->user();

            // Update user fields
            $userData = [];
            if ($request->filled('name')) $userData['name'] = $request->name;
            if ($request->filled('email')) $userData['email'] = $request->email;
            if ($request->filled('description')) $userData['description'] = $request->description;
            if ($request->filled('phone')) $userData['phone'] = $request->phone;
            if ($request->filled('address')) $userData['address'] = $request->address;
            if ($request->filled('password')) $userData['password'] = Hash::make($request->password);
            
            if (!empty($userData)) {
                $user->update($userData);
            }

            // Ensure profile exists
            $profile = $user->profile ?? $user->profile()->create([]);

            // Handle photo upload / removal
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }

                $file = $request->file('photo');
                $photoPath = $file->store('profiles', 'public');
                $user->photo = $photoPath;
                $user->save();
            } elseif ($request->filled('remove_photo')) {
                // Remove photo
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }
                $user->photo = null;
                $user->save();
            }

            // Refresh user data
            $user = $user->fresh();
            
            // Add photo_url field untuk frontend
            $userArray = $user->toArray();
            $userArray['photo_url'] = $user->photo ? Storage::url($user->photo) : null;
            
            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $userArray,
                'profile' => $profile
            ]);
        } catch (\Throwable $e) {
            report($e);
            $msg = config('app.debug') ? $e->getMessage() : 'Gagal memperbarui profil';
            return response()->json(['message' => $msg], 500);
        }
    }

    public function listUsers()
    {
        return response()->json(\App\Models\User::all());
    }
}
