<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin=Auth::user();
        if($admin){
            if ($admin->user_type == 0) {
                return $next($request);
            }else{
                return redirect()->route('admin login')->with('error',"You're not allowed to access here");
            }
        }else{
            return redirect()->route('admin login')->with('error',"you must login first");
        }
        

    }
}
