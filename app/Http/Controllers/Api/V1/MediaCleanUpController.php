<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaCleanUpController
{
    public function getMedia()
    {
        $medias = Media::all();
        $basePath = storage_path('app/public/');
        $newFolder = $basePath . 'New Image/';
        $used_media_count = count($medias);
        $usedImages = [];

        // Create the folder if it doesn't exist
        if (!file_exists($newFolder)) {
            mkdir($newFolder, 0755, true);
        }

        foreach ($medias as $media) {
            $folderPath = $media->path;
            $imagePath = $basePath . $folderPath;

            if (file_exists($imagePath)) {
                $newPath = $newFolder . basename($imagePath); // move file to "New Image" with same name
                if (rename($imagePath, $newPath)) {
                    $usedImages[] = $newPath;
                }
            }
        }

        return response()->json([
            'media_count' => $used_media_count,
            'moved_images' => count($usedImages),
            'new_paths' => $usedImages
        ]);
    }
}
