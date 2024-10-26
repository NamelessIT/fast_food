<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $account_type = auth()->user()->user_type;
            if ($account_type == config('constants.user.customer')) {
                return redirect()->route('home.index');
            }
            else if ($account_type == config('constants.user.employee')) {
                return redirect()->route('home.index'); // admin
            }
        }
        return $next($request);
    }
}