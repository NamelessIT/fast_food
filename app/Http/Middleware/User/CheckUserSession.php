<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserSession
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('user_id') && session()->has('user_type')) {
            return $next($request);
        }
        return redirect()->route('account.index');
    }
}
