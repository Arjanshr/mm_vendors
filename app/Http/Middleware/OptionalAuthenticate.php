<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
class OptionalAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            $token = PersonalAccessToken::findToken($request->bearerToken());

            if ($token && $token->tokenable) {
                Auth::login($token->tokenable);
            }
        }

        return $next($request);
    }
}
