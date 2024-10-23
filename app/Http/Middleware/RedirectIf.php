<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIf
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            return redirect(route('account.profile'));
        }

        return $next($request);
    }
}
