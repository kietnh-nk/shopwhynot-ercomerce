<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserPublish
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->publish == 0) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tài khoản của bạn đã bị vô hiệu hóa.',
            ]);
        }

        return $next($request);
    }
}
