<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Api\V1', 'prefix' => 'delivery/'], function () {
    Route::group(['prefix' => 'example'], function () {

    });
});
