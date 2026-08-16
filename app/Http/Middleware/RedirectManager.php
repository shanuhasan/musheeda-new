<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Redirect as RedirectModel;

class RedirectManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        // Check for redirect rule matching the exact path (without leading slash, which is default for $request->path())
        // Also check if they stored it with a leading slash just in case
        $redirect = RedirectModel::where('is_active', true)
            ->where(function($query) use ($path) {
                $query->where('old_url', $path)
                      ->orWhere('old_url', '/' . $path);
            })
            ->first();

        if ($redirect) {
            $newUrl = $redirect->new_url;
            
            // Prevent infinite loops if new_url is same as current path
            if (trim($newUrl, '/') !== trim($path, '/')) {
                // If the redirect status is 410 (Gone), handle it appropriately
                if ($redirect->status_code == 410) {
                    abort(410);
                }

                return redirect($newUrl, $redirect->status_code ?? 301);
            }
        }

        return $next($request);
    }
}
