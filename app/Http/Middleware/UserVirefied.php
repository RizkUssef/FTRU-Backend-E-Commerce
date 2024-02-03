<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserVirefied
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user) {
            if ($user->user_type == 1) {
                if ($user->email_verified_at != null) {
                    return $next($request);
                } else {
                    return redirect()->route('otp')->with("error", "you must verify your email first ☻");
                }
            } else {
                return redirect()->route('register')->with("error", 'create your account first');
            }
        } else {
            return redirect()->route('login')->with("error", 'you must login first');
        }
    }
}
