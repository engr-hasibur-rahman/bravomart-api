<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductAuthorInterface;
use Illuminate\Http\Request;

class ProductAuthorController extends Controller
{
    public function __construct(
        protected ProductAuthorInterface $authorRepo,
    ) {}
    public function index(Request $request)
    {
        return $this->authorRepo->getPaginatedAuthor(
            $request->limit ?? 10,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
        );
    }
}
