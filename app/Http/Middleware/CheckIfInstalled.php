<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Paths to exclude from middleware check
        $excludedPaths = [
            'install/assets/*',
            'install*',
            'installer*',
        ];

        foreach ($excludedPaths as $excluded) {
            if ($request->is($excluded)) {
                return $next($request);
            }
        }

//        if (env('INSTALLED') !== true) {
//            return response()->json([
//                'message' => 'Installation is not completed yet.',
//                'success' => false
//            ], 403);
//        }

        return $next($request);
    }
}
