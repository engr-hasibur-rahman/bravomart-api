<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Models\Media;
use App\Services\MediaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{

    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function mediaUpload(Request $request)
    {

        if (empty($request->all())) {
            return response()->json([
                'error' => 'No data provided in the request.',
            ], 400);
        }

        $rules = [
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp|max:10240', // max size 10MB
        ];
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }

        $media = $this->mediaService->insert_media_image($request);

        return response()->json([
            'message' => 'Media uploaded successfully.',
            'image_id' => $media->id ?? null,
        ], 201);
    }

    public function load_more(Request $request){
        $all_images = $this->mediaService->load_more_images($request);
        return response()->json([
            'images' => $all_images,
        ]);
    }

    public function alt_change(Request $request){
        $request->validate([
            'image_id' => 'required|integer|exists:media,id',
            'alt' => 'nullable|string|max:255',
        ]);

        $response = $this->mediaService->image_alt_change($request);
        return response()->json([
            'message' => $response['msg'],
            'success' => $response['success'],
        ], 200);
    }

    public function delete_media(Request $request){
        $validator = Validator::make($request->all(), [
            'image_id' => 'required|integer|exists:media,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $response = $this->mediaService->delete_media_image($request);
        return response()->json([
            'message' => $response['msg'],
            'success' => $response['success'],
        ], $response['success'] ? 200 : 500);
    }

    public function allMediaManage(Request $request){
        $query = Media::query();
        // Filter by media name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $all_media = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $all_media->map(function ($item) {
                return [
                    'id'       => $item->id,
                    'name'     => $item->name,
                    'format'   => $item->format,
                    'size'     => $item->file_size,
                    'dimensions'  => $item->dimensions,
                    'type'     => $item->format,
                    'path'     => $item->path,
                ];
            }),
            'meta' => new PaginationResource($all_media)
        ]);
    }

    public function mediaFileDelete(Request $request){

        $validator = Validator::make($request->all(), [
            'image_id' => 'required|integer|exists:media,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $response = $this->mediaService->admin_delete_media_image($request);

        return response()->json([
            'message' => $response['msg'],
            'success' => $response['success'],
        ], $response['success'] ? 200 : 500);
    }

}

