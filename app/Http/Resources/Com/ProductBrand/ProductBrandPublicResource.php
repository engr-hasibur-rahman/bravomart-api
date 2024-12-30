<?php

namespace App\Http\Resources\Com\ProductBrand;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Enums\UploadDirectory;
use App\Helpers\ComHelper;

class ProductBrandPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */

     public function toArray($request)
     {
         $language = $request->language;
         $locales = $this->translations->where('language', $language)->keyBy('key')->toArray();
         return [
             'value' => $this->id,
             'label' => $locales['brand_name']['value'] ?? $this->brand_name,

         ];
     }
}
