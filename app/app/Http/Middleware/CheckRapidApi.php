<?php

namespace App\Http\Middleware;

use Closure;

class CheckRapidApi
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
        $RAPID_API_KEYS = explode(",", env("RAPID_API_KEY"));
        if ($_SERVER['SERVER_NAME'] != "laravel.local" &&
            (!$request->header('X-RapidAPI-Proxy-Secret') || !in_array($request->header('X-RapidAPI-Proxy-Secret'), $RAPID_API_KEYS))) {
            return response(['Bad Request. You need to use RapidApi to access this data'],400);
        }

        return $next($request);
    }
}
