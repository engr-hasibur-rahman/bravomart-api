<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\SliderRequest;
use App\Http\Resources\Admin\AdminSliderResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\SliderManageInterface;
use Illuminate\Http\Request;

class SliderManageController extends Controller
{
    public function __construct(protected SliderManageInterface $sliderRepo)
    {
    }

    public function index(Request $request)
    {
        $sliders = $this->sliderRepo->getPaginatedSlider(
            $request->per_page ?? 10,
            $request->language ?? 'en',
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            $request->platform ?? ""
        );
        return response()->json([
            'data' => AdminSliderResource::collection($sliders),
            'meta' => new PaginationResource($sliders)
        ]);
    }

    public function store(SliderRequest $request)
    {
        $slider = $this->sliderRepo->store($request->all());
        createOrUpdateTranslation($request, $slider, 'App\Models\Slider', $this->sliderRepo->translationKeys());
        if ($slider) {
            return $this->success(translate('messages.save_success', ['name' => 'Slider Details']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Slider Details']));
        }
    }

    public function update(SliderRequest $request)
    {
        $slider = $this->sliderRepo->update($request->all());
        createOrUpdateTranslation($request, $slider, 'App\Models\Slider', $this->sliderRepo->translationKeys());
        if ($slider) {
            return $this->success(translate('messages.update_success', ['name' => 'Slider Details']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Slider Details']));
        }
    }

    public function show(Request $request)
    {
        return $this->sliderRepo->getSliderById($request->id);
    }

    public function changeStatus(Request $request)
    {
        return $this->sliderRepo->changeStatus($request->id);
    }

    public function destroy($id)
    {
        $this->sliderRepo->delete($id);
        return $this->success(translate('messages.delete_success', ['name' => 'Slider Details']));
    }
}
