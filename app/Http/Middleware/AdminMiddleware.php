<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('signin', ['redirect' => $request->path()]);
        }

        $user = Auth::user();
        
        // Allowed roles: Super Admin (1), Admin (2), Inventory Manager (3), Customer Support (4)
        if (is_null($user->role_id) || !in_array($user->role_id, [1, 2, 3, 4])) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized access.'], 403);
            }
            abort(403, 'Unauthorized access to admin panel.');
        }

        return $next($request);
    }
}
