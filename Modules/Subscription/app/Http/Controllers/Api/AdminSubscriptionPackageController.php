<?php

namespace Modules\Subscription\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Subscription\app\Models\Subscription;

class AdminSubscriptionPackageController extends Controller
{
    public function index()
    {
        $packages = Subscription::all(); // Fetch all packages
        return response()->json($packages);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'validity' => 'required|integer',
            'price' => 'required|numeric',
            'pos_system' => 'nullable|boolean',
            'self_delivery' => 'nullable|boolean',
            'mobile_app' => 'nullable|boolean',
            'live_chat' => 'nullable|boolean',
            'order_limit' => 'nullable|integer',
            'product_limit' => 'nullable|integer',
            'product_featured_limit' => 'nullable|integer',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Validation errors
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);  // 422 Unprocessable Entity
        }

        // create the subscription package
        $subscription = Subscription::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription package created successfully',
        ], 201);
    }

    public function show($id)
    {
        $package = Subscription::findOrFail($id); // Fetch the package by ID
        return response()->json($package);
    }

    public function statusChange(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:subscription_packages,id',
            'status' => 'required|boolean',
        ]);

        $package = Subscription::findOrFail($data['id']);
        $package->update(['status' => $data['status']]); // Update status
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function destroy($id)
    {
        $package = Subscription::findOrFail($id);
        $package->delete(); // Delete the package
        return response()->json(['message' => 'Package deleted successfully']);
    }
}
