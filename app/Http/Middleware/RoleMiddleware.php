<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin,employee')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // إذا لم يكن مسجلاً للدخول، وجهه للـ login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // إذا كان دوره غير مسموح به، امنعه
        if (! in_array(Auth::user()->role, $roles)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
