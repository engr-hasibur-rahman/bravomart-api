<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public function uploadFile($file)
    {
        $fileName = Str::random(20) . '.' . $file->extension();
        if (!$file || !$file->isValid()) {
            throw new \Exception('Invalid file provided for upload.');
        }
        Storage::disk('public')->putFileAs('uploads', $file, $fileName);

        // Return the relative path
        return 'uploads/' . $fileName;
    }
}
