<?php

namespace App\Http\Middleware\Backend;

use Closure;

class ActiveMembers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = auth()->user();

        if(!$auth->status) {
            auth()->logout();
            return redirect()->back()->with('error', 'Your account is currently deactivated by the admin');
        }

        return $next($request);
    }
}
