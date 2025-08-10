<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\SettingOption;
use App\Models\Media;

class ComHelper
{

    public static function format_coordiantes($coordinates)
    {
        $data = [];
        foreach ($coordinates as $coord) {
            $data[] = (object)['lat' => $coord[1], 'lng' => $coord[0]];
        }
        return $data;
    }

    public static function get_com_settings($name)
    {
        $config = null;
        $paymentmethod = SettingOption::where('option_name', $name)->first();
        if ($paymentmethod) {
            $config = json_decode($paymentmethod->value, true);
        }

        return $config;
    }

    public static function getDirectory()
    {
        $config = ComHelper::get_com_settings('local_storage');
        return isset($config) ? ($config == 0 ? 's3' : 'public') : 'public';
    }

    public static function get_image_base_url()
    {
        //For Dynamic URL. Like AWS/CloudFront/Local
        return env('APP_URL') . '/storage';
    }

    public static function uploadSingle(string $dir, $file, string $old_image = null, string $format = null): string
    {
        try {
            if ($old_image != null) {
                $file_path = $dir . '/' . $old_image;
                if (Storage::disk(self::getDirectory())->exists($file_path)) {
                    Storage::disk(self::getDirectory())->delete($file_path);
                }
            }

            // Upload File
            if ($file != null) {
                $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $file->extension();
                if (!Storage::disk(self::getDirectory())->exists($dir)) {
                    Storage::disk(self::getDirectory())->makeDirectory($dir);
                }
                Storage::disk(self::getDirectory())->putFileAs($dir, $file, $imageName);
            } else {
                $imageName = 'noimage.png';
            }
        } catch (\Exception $e) {
        }
        return $imageName;
    }

    public static function uploadMulti(string $dir, array $files, array $old_images = null, string $format = null): array
    {
        $fileNames = [];
        try {
            foreach ($old_images as $old_image) {
                if ($old_image != null) {
                    $file_path = $dir . '/' . $old_image;
                    if (Storage::disk(self::getDirectory())->exists($file_path)) {
                        Storage::disk(self::getDirectory())->delete($file_path);
                    }
                }
            }

            // Upload files one by One
            foreach ($files as $file) {
                if ($file != null) {
                    $fileName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $file->extension();
                    if (!Storage::disk(self::getDirectory())->exists($dir)) {
                        Storage::disk(self::getDirectory())->makeDirectory($dir);
                    }
                    Storage::disk(self::getDirectory())->putFileAs($dir, $file, $fileName);
                } else {
                    $fileName = 'noimage.png';
                }
                $fileNames[] = $fileName;
            }
        } catch (\Exception $e) {
        }
        return $fileNames;
    }


    public static function buildMenuTree(array $role_id, $data_list)
    {
        $tree = [];
        foreach ($data_list as $data_item) {
            $children = $data_item->childrenRecursive != '' && count($data_item->childrenRecursive)
                ? ComHelper::buildMenuTree($role_id, $data_item->childrenRecursive)
                : [];
            $users = DB::table('role_has_permissions')->where('permission_id', $data_item->id)->whereIn('role_id', $role_id)->first();
            $translations = Translation::where('translatable_type', 'App\Models\Permissions')->where('translatable_id', $data_item->id)->get()->groupBy('language');
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $itemData = [
                    'language' => $language,
                    'perm_title' => $items->where('key', 'perm_title')->first()->value ?? null,
                ];
                $transformedData[] = $itemData;
            }

            $options = [];
            $decodedOptions = $data_item->options;
            // Check and decode options
            if (is_string($decodedOptions)) {
                $decodedOptions = json_decode($decodedOptions, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    logger('JSON decode error for options:', [
                        'error' => json_last_error_msg(),
                        'options' => $data_item->options,
                    ]);
                    $decodedOptions = [];
                }
            }

           // Ensure decoded options is an array
            if (is_array($decodedOptions)) {
                $options = array_map(function ($allowedValue) use ($users) {
                    if (is_string($allowedValue)) {
                        return [
                            'label' => $allowedValue,
                            'value' => $users && property_exists($users, $allowedValue)
                                ? (bool)$users->$allowedValue
                                : false,
                        ];
                    }

                    // If not a string, log it and skip this item
                    logger('Invalid allowed value type:', ['allowedValue' => $allowedValue]);
                    return null; // Skip invalid values
                }, $decodedOptions);
                // Remove null values caused by invalid items
                $options = array_filter($options);
            } else {
                logger('Decoded options is not an array or is invalid:', ['decodedOptions' => $decodedOptions]);
            }

            $tree[] = [
                'id' => $data_item->id,
                'perm_title' => $data_item->perm_title,
                'perm_name' => $data_item->name,
                'type' => $data_item->type ?? null,
                'icon' => $data_item->icon,
                'translations' => $transformedData,
                'options' => $options,
                'children' => $children,
            ];
        }
        return $tree;
    }

    public static function markAssignedPermissions($permissions, $rolePermissions)
    {
        return $permissions->map(function ($permission) use ($rolePermissions) {
            // Check if the current permission is assigned
            $permission->is_assigned = $rolePermissions->contains('id', $permission->id);

            // Recursively mark children permissions
            if ($permission->relationLoaded('childrenRecursive')) {
                $permission->children = ComHelper::markAssignedPermissions(
                    $permission->children,
                    $rolePermissions
                );
            }

            return $permission;
        });
    }
}
