<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class AdminReviewManageController extends Controller
{
    public function __construct(protected ReviewService $reviewService)
    {

    }
    public function index()
    {
    }

    public function approveReview()
    {
    }

    public function rejectReview()
    {
    }

    public function destroy()
    {
    }

}
