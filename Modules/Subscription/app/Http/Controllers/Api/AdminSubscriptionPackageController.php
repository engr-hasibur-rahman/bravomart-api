<?php

namespace Modules\Subscription\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscription\Models\Subscription;

class AdminSubscriptionPackageController extends Controller
{
    public function index()
    {
        $packages = Subscription::all(); // Fetch all packages
        return response()->json($packages);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'validity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $package = Subscription::create($data); // Create a new package
        return response()->json($package, 201);
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
