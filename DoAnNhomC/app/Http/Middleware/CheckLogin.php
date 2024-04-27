<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 1) {
                return redirect()->route('admin.dashboard');                // Chuyển hướng nếu đăng nhập với vai trò là 1
            } else {
                return redirect()->route('dashboard'); // Chuyển hướng nếu đăng nhập với vai trò không phải là 1
            }
        }
    
        return $next($request);
    }
}
