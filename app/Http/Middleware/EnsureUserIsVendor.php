<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if the user is logged in and has the 'vendor' role
        if (!$request->user() || !$request->user()->hasRole('vendor')) {
            if (method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }

            Auth::guard('web')->logout(); // In case of session-based (web) logout

            if ($request->expectsJson()) {
                // For API requests
                return response()->json([
                    'message' => 'You must be a vendor to access this resource.'
                ], 403);
            }

            // For web requests
            return redirect()->route('login')->withErrors([
                'email' => 'You must be a vendor to access this resource.'
            ]);
        }

        return $next($request);
    }
}