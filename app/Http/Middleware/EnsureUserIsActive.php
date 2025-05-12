<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Always get the latest user data from the database
        if ($user) {
            $user = $user->fresh();
        }

        Log::info('EnsureUserIsActive middleware triggered', [
            'user_id' => $user?->id,
            'user_status' => $user?->status,
            'is_api' => $request->expectsJson()
        ]);

        if ($user && $user->status !== 'active') {
            // Revoke all tokens for the user (for Sanctum)
            if (method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }

            Auth::guard('web')->logout(); // In case of session-based (web) logout

            if ($request->expectsJson()) {
                // For API requests
                return response()->json([
                    'message' => 'Your account is inactive. Please contact support.'
                ], 403);
            }

            // For web requests
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is inactive. Please contact support.'
            ]);
        }

        return $next($request);
    }
}
