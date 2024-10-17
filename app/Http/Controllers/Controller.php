<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message 
        ]);
    }

    public function failed($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message 
        ]);
    }
}
