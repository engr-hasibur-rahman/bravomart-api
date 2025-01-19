<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComStoreNotice;
use Illuminate\Http\Request;

class AdminStoreNoticeController extends Controller
{
    /**
     * Display a listing of the notices.
     */
    public function index()
    {
        $notices = ComStoreNotice::all();
        return response()->json(['data' => $notices], 200);
    }

    /**
     * Store a newly created notice in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'nullable|string',
            'type' => 'required|string|in:general,specific_store,specific_vendor',
            'priority' => 'integer|min:0|max:2',
            'active_date' => 'required|date',
            'expire_date' => 'required|date|after_or_equal:active_date',
        ]);

        $notice = ComStoreNotice::create($validated);

        return response()->json(['message' => 'Notice created successfully.', 'data' => $notice], 201);
    }

    /**
     * Display the specified notice.
     */
    public function show($id)
    {
        $notice = ComStoreNotice::findOrFail($id);
        return response()->json(['data' => $notice], 200);
    }

    /**
     * Update the specified notice in storage.
     */
    public function update(Request $request, $id)
    {
        $notice = ComStoreNotice::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'message' => 'nullable|string',
            'type' => 'sometimes|required|string|in:general,specific_store,specific_vendor',
            'priority' => 'integer|min:0|max:2',
            'active_date' => 'sometimes|required|date',
            'expire_date' => 'sometimes|required|date|after_or_equal:active_date',
        ]);

        $notice->update($validated);

        return response()->json(['message' => 'Notice updated successfully.', 'data' => $notice], 200);
    }

    /**
     * Update the status of a specific notice.
     */
    public function statusChange(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|integer|in:0,1',
        ]);

        $notice = ComStoreNotice::findOrFail($id);
        $notice->status = $validated['status'];
        $notice->save();

        return response()->json(['message' => 'Status updated successfully.', 'data' => $notice], 200);
    }

    /**
     * Remove the specified notice from storage.
     */
    public function destroy($id)
    {
        $notice = ComStoreNotice::findOrFail($id);
        $notice->delete();

        return response()->json(['message' => 'Notice deleted successfully.'], 200);
    }
}
