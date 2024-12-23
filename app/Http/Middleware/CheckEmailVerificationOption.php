<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CheckEmailVerificationOption
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
//        dd(auth('api')->email());
//        $customerIsEmailVerified = Customer::where('email', auth('api')->id())
//            ->where('email_verified', 1)
//            ->first();
//
//        // Fetch the option value from the database
//        $emailVerificationEnabled = DB::table('com_options')
//            ->where('option_name', 'com_user_email_verification') // Ensure you're checking the correct key
//            ->value('option_value');
//        if (!$customerIsEmailVerified && $emailVerificationEnabled !== null) {
//            return response()->json([
//                'status' => false,
//                'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
//                'message' => 'Email verification is not completed.',
//            ], 403);
//        }
//
//        // Proceed if enabled
//        return $next($request);
        try {
            // Log the incoming token
            Log::info('Incoming token: ' . $request->bearerToken());

            if (Auth::guard('sanctum')->check()) {
                Log::info('User authenticated via sanctum');
                return $next($request);
            }

            if (Auth::guard('customer')->check()) {
                Log::info('Customer authenticated');
                return $next($request);
            }

            // If no authentication, return proper JSON response
            return response()->json([
                'message' => 'Unauthenticated',
                'status' => 401
            ], 401);

        } catch (\Exception $e) {
            Log::error('Authentication error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Authentication error',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

}
