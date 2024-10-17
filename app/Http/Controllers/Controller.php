<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($message,$status_code=200)
    {
        return response()->json([
            'success' => true,
            'message' => $message 
        ],$status_code);
    }

    public function failed($message,$status_code=403)
    {
        return response()->json([
            'success' => false,
            'message' => $message 
        ],$status_code);
    }
}
