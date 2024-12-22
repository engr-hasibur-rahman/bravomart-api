<?php

namespace App\Repositories;

use App\Interfaces\CustomerManageInterface;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerManageRepository implements CustomerManageInterface
{
    public function __construct(protected Customer $customer)
    {

    }

    public function register(array $data)
    {
        try {
            return $this->customer->create($data);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => __('messages.error'),
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function getToken(array $data)
    {
        try {
            // Attempt to find the user
            $customer = $this->customer->where('email', $data['email'])
                ->where('status', 1)
                ->first();
            if (!$customer) {
                return response()->json([
                    "status" => false,
                    "status_code" => 404,
                    "message" => __('messages.customer.not.found'),
                ], 404);
            }
            $authCustomer = Hash::check($data['password'], $customer->password);
            // Check if the user exists and if the password is correct
            if (!$authCustomer) {
                return response()->json([
                    "status" => false,
                    "status_code" => 401,
                    "message" => __('messages.login_failed', ['name' => 'Customer']),
                    "token" => null,
                ], 401);
            }
            // Build and return the response
            return $customer;
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
