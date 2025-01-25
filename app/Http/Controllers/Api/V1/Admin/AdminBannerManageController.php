<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminBannerRequest;
use App\Http\Resources\Admin\AdminBannerDetailsResource;
use App\Http\Resources\Admin\AdminBannerResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\BannerManageInterface;
use Illuminate\Http\Request;

class AdminBannerManageController extends Controller
{
    public function __construct(protected BannerManageInterface $bannerRepo)
    {

    }

    public function index(Request $request)
    {
        $banner = $this->bannerRepo->getPaginatedBanner(
            $request->per_page ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
        return response()->json([
            'data' => AdminBannerResource::collection($banner),
            'meta' => new PaginationResource($banner)
        ]);
    }

    public function store(AdminBannerRequest $request)
    {
        $banner = $this->bannerRepo->store($request->all());
        $this->bannerRepo->storeTranslation($request, $banner, 'App\Models\Banner', $this->bannerRepo->translationKeys());
        if ($banner) {
            return $this->success(__('messages.save_success', ['name' => 'Banner']));
        } else {
            return $this->failed(__('messages.save_failed', ['name' => 'Banner']));
        }
    }

    public function update(AdminBannerRequest $request)
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
        return response()->json(new AdminBannerDetailsResource($banner));
    }

    public function destroy($id)
    {
        $this->bannerRepo->delete($id);
        return $this->success(translate('messages.delete_success', ['name' => 'Banner']));
    }
}
