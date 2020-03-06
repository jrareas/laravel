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
        if ($request->url() != "laravel.local" &&
            (!$request->header('X-RapidAPI-Proxy-Secret') || $request->header('X-RapidAPI-Proxy-Secret') != env("RAPID_API_KEY"))) {
            return response(['Bad Request. You need to use RapidApi to access this data'],400);
        }

        return $next($request);
    }
}
