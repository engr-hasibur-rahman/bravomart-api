<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerAddressRequest;
use App\Http\Resources\Customer\CustomerAddressResource;
use App\Interfaces\AddressManageInterface;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerAddressManageController extends Controller
{
    public function __construct(protected AddressManageInterface $addressRepo)
    {

    }

    public function store(CustomerAddressRequest $request)
    {

        // Check if the user is authenticated
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        try {
            // Set the customer ID if authenticated
            $request['customer_id'] = auth('api_customer')->user()->id;
            // Store the address using the repository
            $this->addressRepo->setAddress($request->all());

            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => __('messages.save_success', ['name' => 'Customer address'])
            ], 201);

        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $status = $request->input('status');
        $addresses = $this->addressRepo->getAddress($id, $type, $status);
        return CustomerAddressResource::collection($addresses);
    }

    public function show(Request $request)
    {
        try {
            return response()->json(new CustomerAddressResource($this->addressRepo->getAddressById($request->id)));
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function defaultAddress(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'is_default' => 'required|boolean',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors()
            ], 422);
        }
        try {
            CustomerAddress::findOrFail($request->id);
            // Set the customer ID if authenticated
            $request['customer_id'] = auth('api')->id();
            $this->addressRepo->handleDefaultAddress($request->all());
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.update_success', ['name' => 'Default address'])
            ], 200);
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
