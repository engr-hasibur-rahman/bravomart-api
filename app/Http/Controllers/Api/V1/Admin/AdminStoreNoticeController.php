<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Interfaces\NoticeManageInterface;
use App\Models\ComStoreNotice;
use Illuminate\Http\Request;

class AdminStoreNoticeController extends Controller
{
    public function __construct(protected NoticeManageInterface $noticeRepo)
    {

    }

    public function index()
    {
        $notices = ComStoreNotice::all();
        return response()->json(['data' => $notices], 200);
    }

    public function store(NoticeRequest $request)
    {
        $success = $this->noticeRepo->createNotice($request->all());
        if ($success) {
            return $this->success(__('messages.save_success', ['name' => 'Notice']));
        } else {
            return $this->failed(__('messages.save_failed', ['name' => 'Notice']));
        }
    }

    public function show($id)
    {
        $notice = ComStoreNotice::findOrFail($id);
        return response()->json(['data' => $notice], 200);
    }

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

    public function destroy($id)
    {
        $notice = ComStoreNotice::findOrFail($id);
        $notice->delete();

        return response()->json(['message' => 'Notice deleted successfully.'], 200);
    }
}
