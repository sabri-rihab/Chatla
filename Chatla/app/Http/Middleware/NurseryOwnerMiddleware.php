<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * NurseryOwnerMiddleware
 *
 * Responsibilities:
 *  1. Verify the user is authenticated (Laravel's 'auth' middleware handles the
 *     actual JWT/session check — this middleware assumes auth has already run).
 *  2. Verify the user's role is 'nursery_owner'.
 *  3. Verify the nursery_owner has a nursery registered.
 *  4. Attach $request->nursery  so controllers don't repeat the query.
 */
class NurseryOwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // ── 1. Must be authenticated ──────────────────────────────────
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please log in.',
            ], Response::HTTP_UNAUTHORIZED);    // 401
        }

        // ── 2. Must have the nursery_owner role ───────────────────────
        if ($user->role !== 'nursery_owner') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Nursery owners only.',
            ], Response::HTTP_FORBIDDEN);       // 403
        }

        // ── 3. Must own a nursery ─────────────────────────────────────
        $nursery = $user->nursery;   // hasOne(Nursery::class, 'owner_id')

        if (! $nursery) {
            return response()->json([
                'success' => false,
                'message' => 'No nursery found for this account. Please contact support.',
            ], Response::HTTP_FORBIDDEN);       // 403
        }

        // ── 4. Attach nursery to the request for downstream use ───────
        $request->merge(['_nursery' => $nursery]);
        // Convenience accessor: $request->nursery() or $request->attributes
        $request->attributes->set('nursery', $nursery);

        return $next($request);
    }
}
