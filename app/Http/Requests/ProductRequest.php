<?php

namespace App\Http\Requests;

use App\Enums\Behaviour;
use App\Enums\StatusType;
use App\Enums\StoreType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "shop_id" => "required",
            "category_id" => "required",
            "brand_id" => "required",
            "unit_id" => "required",
            "attribute_id" => "required",
            "tag_id" => "required",
            "type" => "required|in:" . implode(',', array_column(StoreType::cases(), 'value')),
            "name" => "required",
            "description" => "required",
            "image" => "nullable",
            "gallery_images" => "nullable",
            "warranty" => "nullable",
            "return_in_dsays" => "nullable",
            "cash_on_delivery" => "nullable",
            "behaviour" => "required|in:" . implode(',', array_column(Behaviour::cases(), 'value')),
            "delivery_time_min" => "nullable",
            "delivery_time_max" => "nullable",
            "delivery_time_text" => "nullable",
            "attributes" => "required",
            "status" => "required|in:" . implode(',', array_column(StatusType::cases(), 'value')),
        ];
    }
    public function messages()
    {
        return [
            "shop_id.required" => "The shop ID is required.",
            "category_id.required" => "The category ID is required.",
            "brand_id.required" => "The brand ID is required.",
            "unit_id.required" => "The unit ID is required.",
            "attribute_id.required" => "The attribute ID is required.",
            "tag_id.required" => "The tag ID is required.",
            "type.required" => "The status is required. Valid statuses are: " . $this->getEnumValues(StoreType::class),
            "type.in" => "The selected status is invalid. Valid statuses are: " . $this->getEnumValues(StoreType::class),
            "behaviour.required" => "The status is required. Valid statuses are: " . $this->getEnumValues(Behaviour::class),
            "behaviour.in" => "The selected status is invalid. Valid statuses are: " . $this->getEnumValues(Behaviour::class),
            "name.required" => "The product name is required.",
            "slug.required" => "The slug is required and must be unique.",
            "description.required" => "The product description is required.",
            // "image.required" => "The main image of the product is required.",
            // "gallery_images.required" => "Gallery images are required.",
            // "warranty.required" => "Warranty information is required.",
            // "return_in_dsays.required" => "The return policy duration is required.",
            // "cash_on_delivery.required" => "Specify if cash on delivery is available.",
            // "delivery_time_min.required" => "The minimum delivery time is required.",
            // "delivery_time_max.required" => "The maximum delivery time is required.",
            // "delivery_time_text.required" => "Delivery time text is required.",
            "attributes.required" => "Attributes must be specified.",
            "status.required" => "The status is required. Valid statuses are: " . $this->getEnumValues(StatusType::class),
            "status.in" => "The selected status is invalid. Valid statuses are: " . $this->getEnumValues(StatusType::class),
        ];
    }
    private function getEnumValues(string $enumClass): string
    {
        return implode(', ', array_map(fn($case) => $case->value, $enumClass::cases()));
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
