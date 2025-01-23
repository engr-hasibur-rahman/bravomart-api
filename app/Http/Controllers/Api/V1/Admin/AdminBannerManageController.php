<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Http\Resources\Banner\BannerPublicResource;
use App\Interfaces\BannerManageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminBannerManageController extends Controller
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
        return BannerPublicResource::collection($banner);
    }

    public function store(BannerRequest $request): JsonResponse
    {
        $banner = $this->bannerRepo->store($request->all());
        $this->bannerRepo->storeTranslation($request, $banner, 'App\Models\Banner', $this->bannerRepo->translationKeys());
        if ($banner) {
            return $this->success(translate('messages.save_success', ['name' => 'Banner']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Banner']));
        }
    }

    public function update(BannerRequest $request)
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
        return $this->bannerRepo->getBannerById($request->id);
    }

    public function destroy($id)
    {
        $this->bannerRepo->delete($id);
        return $this->success(translate('messages.delete_success', ['name' => 'Banner']));
    }
}
