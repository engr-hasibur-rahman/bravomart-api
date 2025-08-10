<?php

namespace App\Repositories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class FileUploadRepository extends BaseRepository
{

    public function model()
    {
        return Media::class;
    }

    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
            //
        }
    }

    /*
        https://github.com/spatie/laravel-medialibrary
        Original File Path \vendor\spatie\laravel-medialibrary\src\MediaCollections\Models\Media.php
    */
    function attachment($file, $collectionName, $id = null, $collection, ?array $custom_properties)
    {
        if ($id && $collection->hasMedia($collectionName)) {
            $collection->clearMediaCollection($collectionName);
        }
        $collection->addMedia($file)->withCustomProperties($custom_properties)->toMediaCollection($collectionName);
    }

    /*
    Upload File to Direcotry
    */
    public function uploadFile($file, $brandId = null, $brand, string $description = null, string $type = null)
    {
        // Prepare file extension and type
        $extension = $file->extension();
        $type = $type ?? (in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension);

        $fileName = Str::random(20) . '.' . $file->extension();
        $filePath = Storage::disk('public')->putFileAs('uploads', $file, $fileName);

        $fullUrl = url('storage/uploads/' . $fileName);
        if ($brandId) {
            $existingMedia = $brand->media()->first();

            if ($existingMedia) {
                $ildPath = $existingMedia->path;

                if (Storage::disk('public')->exists($ildPath)) {
                    Storage::disk('public')->delete($ildPath);
                }
                $existingMedia->delete();
            }
        }

        // Return the necessary data for database insertion
        return [
            'name' => $file->getClientOriginalName(),
            'type' => $file->getClientMimeType(),
            'src' => $fullUrl, // File path relative to public directory
            'extension' => $extension,
            'description' => $description ?? 'Default description',
            'path' => $filePath, // The full path where the file is stored
        ];
    }

    public function uploadMultipleFiles(array $files, Model $fileable, string $description = null, string $type = null)
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            $extension = $file->extension();
            if (! $type) {
                $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
            }

            $fileName = Str::random(20) . '.' . $file->extension();
            $filePath = Storage::disk('public')->putFileAs('uploads', $file, $fileName);

            // Create media record
            $media = $fileable->media()->create([
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientMimeType(),
                'src' => $filePath,
                'extension' => $file->extension(),
                'description' => $description ?? 'Default description',
                'path' => $filePath,
            ]);

            $uploadedFiles[] = $media;
        }

        return $uploadedFiles;
    }
}


 // $fileName = Str::random(20) . '.' . $file->extension();
        // if (!$file || !$file->isValid()) {
        //     throw new \Exception('Invalid file provided for upload.');
        // }
        // Storage::disk('public')->putFileAs('uploads', $file, $fileName);

        // // Return the relative path
        // return 'uploads/' . $fileName;