<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Usage in routes: ->middleware('permission:menu-slug,can_view')
     */
    public function handle(Request $request, Closure $next, string $menuSlug, string $ability = 'can_view'): Response
    {
        $user = $request->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $allowed = $user->hasPermission($menuSlug, $ability);

        if (!$allowed) {
            if ($request->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'Access denied.'], 403);
            }
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
