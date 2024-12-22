<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Interfaces\CustomerManageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerManageController extends Controller
{
    public function __construct(protected CustomerManageInterface $customerRepo)
    {
    }

    public function register(CustomerRequest $request)
    {
        try {
            $customer = $this->customerRepo->register($request->all());
            $token = $customer->createToken('auth_token')->plainTextToken;
            // Return a successful response with the token and permissions
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.registration_success', ['name' => 'Customer']),
                "token" => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:15',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $validator->errors()
            ]);
        }
        try {
            $token = $this->customerRepo->getToken($request->all());
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.login_success', ['name' => 'Customer']),
                "token" => $token->createToken('auth_token')->plainTextToken
            ]);
        } catch (\Exception $e){
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }
}
