<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class ProfileController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            return response()->json([
                'fileUrl' => url('uploads/' . $filename)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function getProfile(Request $request)
    {
        $admin = Auth::user();

        return response()->json([
            'success' => true,
            'data' => [
                'fullName' => $admin->full_name,
                'username' => $admin->username,
                'gmail' => $admin->email,
                'phoneNumber' => $admin->phone_number,
                'bio' => $admin->bio,
                'profilePictureUrl' => $admin->profile_picture_url,
            ]
        ]);
    }

    public function update(Request $request)
    {
        $admin = Auth::user();


        \Log::info('Profile update request:', $request->all());
        \Log::info('Current user:', $admin->toArray());

        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'profile_picture_url' => 'nullable|string',
        ]);

        // Update the admin
        $updated = $admin->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'bio' => $request->bio,
            'profile_picture_url' => $request->profile_picture_url,
        ]);


        \Log::info('Update result:', ['success' => $updated]);
        \Log::info('Updated admin:', $admin->fresh()->toArray());

        return response()->json([
            'message' => 'Profile updated successfully',
            'admin' => $admin->fresh()
        ]);
    }
}
