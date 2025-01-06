<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerStoreSettingsController extends Controller
{
    public function storeNotices(){

        $notices = ComStoreNotice::get();
        return response()->json([
              'notices' => $notices  
        ]);
    }
}
