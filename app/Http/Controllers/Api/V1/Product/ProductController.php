<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(){

    }
    public function index(Request $request){
        $products = Product::orderBy("id","desc")->with("variant")->paginate(10);
        return response()->json($products);
    }
}
