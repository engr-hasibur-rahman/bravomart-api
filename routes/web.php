<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/install/assets/{any}', function ($any) {
    $path = base_path('install/assets/' . $any);

    if (!file_exists($path)) {
        abort(404);
    }

    $ext = pathinfo($path, PATHINFO_EXTENSION);

    $contentType = match ($ext) {
        'css' => 'text/css',
        'js' => 'application/javascript',
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
        default => 'application/octet-stream',
    };

    return response()->file($path, ['Content-Type' => $contentType]);
})->where('any', '.*');