<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\MediaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function mediaUpload(Request $request)
    {
        $media = $this->mediaService->insert_media_image($request);
        return response()->json([
            'message' => 'Media uploaded successfully.',
            'image_id' => $media->id,
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
        $request->validate([
            'image_id' => 'required|integer|exists:media,id',
        ]);
        $response = $this->mediaService->delete_media_image($request);
        return response()->json([
            'message' => $response['msg'],
            'success' => $response['success'],
        ], $response['success'] ? 200 : 500);
    }

}

