<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonApi
{
    const PARSED_METHODS = [
        'POST', 'PUT', 'PATCH'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->getMethod(), self::PARSED_METHODS)) {
            try {
                $request->merge(json_decode($request->getContent(), true));
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        return $next($request);
    }
}
