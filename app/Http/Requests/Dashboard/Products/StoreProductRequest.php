<?php

namespace App\Http\Requests\Dashboard\Products;

use App\Enums\ProductStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreProductRequest extends FormRequest
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
            "name" => "required|string|max:255|min:3",
            "section" => "nullable|string|max:255|min:3",
            "description" => "nullable|string",
            "image" => "nullable|image",
            "price_after_discount" => "required|numeric",
            "price_before_discount" => "required|numeric",
            "code" => "nullable|string|max:255|unique:products,code",
            "status" => ["nullable", new Enum(ProductStatusEnum::class)]

        ];
    }
}
