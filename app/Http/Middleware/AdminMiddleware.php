<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        // Check if user is authenticated
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            // Log unauthorized access attempt
            Log::warning('Unauthorized admin access attempt', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent()
            ]);

            abort(403, 'Unauthorized action. Admin access required.');
        }

        return $next($request);
    }
}
