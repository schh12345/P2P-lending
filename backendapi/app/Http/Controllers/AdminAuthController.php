<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;
        $adminData = [
            'id' => $admin->id,
            'fullName' => $admin->full_name,
            'username' => $admin->username,
            'gmail' => $admin->email,
            'phoneNumber' => $admin->phone_number ?? '',
            'bio' => $admin->bio ?? '',
            'profilePictureUrl' => $admin->profile_picture_url ?? '',
        ];

        return response()->json([
            'success' => true,
            'token' => $token,
            'admin' => $adminData,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
