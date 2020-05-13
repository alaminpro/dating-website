<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;
use Cache;
class UserActivity
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
        if(Auth::check()){
           $expaire_at = Carbon::now()->addMinutes(1);
           Cache::put('user-is-online-'. Auth::user()->id, true, $expaire_at);
        }
        return $next($request);
    }
}
