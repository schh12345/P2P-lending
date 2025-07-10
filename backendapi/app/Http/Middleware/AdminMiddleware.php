<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
            // check if the user is in the admins table or not
            if ($user) {
                return $next($request);
            }
        }
        return response()->json([
            'message' => 'Unauthorized access. Please contact superadmin@yourdomain.com for further instructions.'
        ], 403);
    }
}
