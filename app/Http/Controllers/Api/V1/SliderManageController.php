<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Interfaces\SliderManageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderManageController extends Controller
{
    public function __construct(protected SliderManageInterface $sliderRepo)
    {
    }

    public function index(Request $request)
    {
        return $this->sliderRepo->getPaginatedSlider(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
    }

    public function store(SliderRequest $request): JsonResponse
    {
        $slider = $this->sliderRepo->store($request->all());
        $this->sliderRepo->storeTranslation($request, $slider, 'App\Models\Slider', $this->sliderRepo->translationKeys());
        if ($slider) {
            return $this->success(translate('messages.save_success', ['name' => 'Slider Details']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Slider Details']));
        }
    }

    public function update(SliderRequest $request)
    {
        $slider = $this->sliderRepo->update($request->all());
        $this->sliderRepo->updateTranslation($request, $slider, 'App\Models\Slider', $this->sliderRepo->translationKeys());
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

    public function destroy($id)
    {
        $this->sliderRepo->delete($id);
        return $this->success(translate('messages.delete_success', ['name' => 'Slider Details']));
    }
}
