<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerBannerRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Seller\SellerBannerDetailsResource;
use App\Http\Resources\Seller\SellerBannerResource;
use App\Interfaces\BannerManageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerBannerManageController extends Controller
{
    public function __construct(protected BannerManageInterface $bannerRepo)
    {

    }

    public function index(Request $request)
    {
        $banner = $this->bannerRepo->getPaginatedBanner(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
        return response()->json([
            'data' => SellerBannerResource::collection($banner),
            'meta' => new PaginationResource($banner)
        ]);
    }

    public function store(SellerBannerRequest $request): JsonResponse
    {
        $banner = $this->bannerRepo->store($request->all());
        $this->bannerRepo->storeTranslation($request, $banner, 'App\Models\Banner', $this->bannerRepo->translationKeys());
        if ($banner) {
            return $this->success(translate('messages.save_success', ['name' => 'Banner']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Banner']));
        }
    }

    public function update(SellerBannerRequest $request)
    {
        $banner = $this->bannerRepo->update($request->all());
        $this->bannerRepo->updateTranslation($request, $banner, 'App\Models\Banner', $this->bannerRepo->translationKeys());
        if ($banner) {
            return $this->success(translate('messages.update_success', ['name' => 'Banner']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Banner']));
        }
    }

    public function show(Request $request)
    {
        $banner = $this->bannerRepo->getBannerById($request->id);
        return response()->json(new SellerBannerDetailsResource($banner));
    }

    public function destroy($id)
    {
        $this->bannerRepo->delete($id);
        return $this->success(translate('messages.delete_success', ['name' => 'Banner']));
    }
}
