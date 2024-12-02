<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\MediaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminMediaController extends Controller
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
            'success' => true,
            'message' => 'Media uploaded successfully.',
            'data' => [
                'image_id' => $media->id,
                'path' => $media->path,
            ],
        ], 201);
    }

}

