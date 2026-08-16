<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrailingSlashMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->getPathInfo();

        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
            $url = $request->getSchemeAndHttpHost() . $path;
            
            if ($request->getQueryString()) {
                $url .= '?' . $request->getQueryString();
            }

            return redirect($url, 301);
        }

        return $next($request);
    }
}
