<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Http\Resources\Admin\AdminNoticeDetailsResource;
use App\Http\Resources\Admin\AdminNoticeResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\NoticeManageInterface;
use App\Models\StoreNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminStoreNoticeController extends Controller
{
    public function __construct(protected NoticeManageInterface $noticeRepo)
    {

    }

    public function index(Request $request)
    {
        $filters = [
            'priority' => $request->input('priority'),
            'status' => $request->input('status'),
            'type' => $request->input('type'),
            'search' => $request->input('search'),
            'per_page' => $request->input('per_page'),
        ];
        $notices = $this->noticeRepo->getNotice($filters);
        return response()->json([
            'data' => AdminNoticeResource::collection($notices),
            'meta' => new PaginationResource($notices),
        ]);
    }

    public function store(NoticeRequest $request)
    {
        if ($request->type == 'general' && (isset($request->store_id) || isset($request->seller_id))) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => 'General notices are not allowed to assign specific store or seller'
            ]);
        }
        $success = $this->noticeRepo->createNotice($request->all());
        $this->noticeRepo->createOrUpdateTranslation($request, $success, 'App\Models\StoreNotice', $this->noticeRepo->translationKeys());
        if ($success) {
            return $this->success(__('messages.save_success', ['name' => 'Notice']));
        } else {
            return $this->failed(__('messages.save_failed', ['name' => 'Notice']));
        }
    }

    public function show(Request $request)
    {
        $notice = $this->noticeRepo->getById($request->id);
        return response()->json(new AdminNoticeDetailsResource($notice));
    }

    public function update(NoticeRequest $request)
    {
        $success = $this->noticeRepo->updateNotice($request->all());
        $this->noticeRepo->createOrUpdateTranslation($request, $success, 'App\Models\StoreNotice', $this->noticeRepo->translationKeys());
        if ($success) {
            return $this->success(__('messages.update_success', ['name' => 'Notice']));
        } else {
            return $this->failed(__('messages.update_failed', ['name' => 'Notice']));
        }
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $success = $this->noticeRepo->toggleStatus($request->id);
        if ($success) {
            return $this->success(__('messages.update_success', ['name' => 'Notice status']));
        } else {
            return $this->failed(__('messages.update_failed', ['name' => 'Notice status']));
        }
    }

    public function destroy($id)
    {
        $success = $this->noticeRepo->deleteNotice($id);
        if ($success) {
            return $this->success(__('messages.delete_success', ['name' => 'Notice']));
        } else {
            return $this->failed(__('messages.delete_failed', ['name' => 'Notice']));
        }
    }
}
