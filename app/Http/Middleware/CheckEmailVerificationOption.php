<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
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
        $authCustomer = auth('api_customer')->user();
        $customerIsEmailVerified = Customer::where('email', $authCustomer->email)
            ->where('email_verified', 1)
            ->first();

        // Fetch the option value from the database
        $emailVerificationEnabled = DB::table('setting_options')
            ->where('option_name', 'com_user_email_verification') // Ensure you're checking the correct key
            ->value('option_value');
        if (!$customerIsEmailVerified && $emailVerificationEnabled !== null) {
            return response()->json([
                'status' => false,
                'status_code' => Response::HTTP_FORBIDDEN,
                'email_verified' => false,
                'message' => 'Email verification is not completed.',
            ]);
        }
        // Proceed if enabled
        return $next($request);
    }
}
