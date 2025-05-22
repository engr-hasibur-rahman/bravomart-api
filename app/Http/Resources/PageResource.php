<?php

namespace App\Http\Resources;

use App\Http\Resources\Translation\PageTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function PHPUnit\Framework\isJson;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $language = $request->input('language', 'en');
        $translation = $this->related_translations->where('language', $language);
        return [
            'id' => $this->id,
            'title' => !empty($translation) && $translation->where('key', 'title')->first()
                ? safeJsonDecode($translation->where('key', 'title')->first()->value)
                : $this->title,
            'slug' => $this->slug
        ];
    }

}
