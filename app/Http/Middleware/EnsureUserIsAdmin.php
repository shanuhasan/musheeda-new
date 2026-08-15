<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has ANY of the admin panel roles
        if ($user->hasAnyRole(['Super Admin', 'Admin', 'Editor', 'Author', 'SEO Manager'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. Admin access required.');
    }
}
