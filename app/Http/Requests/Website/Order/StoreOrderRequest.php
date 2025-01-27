<?php

namespace App\Http\Requests\Website\Order;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreOrderRequest extends FormRequest
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
            "username" => "required|string|min:3|max:255",
            "phone" => "required|string",
            "governorate_id" =>"required|exists:governorates,id",
            "code" => "nullable|string|max:255|unique:orders,code",
            "status" => ["nullable", new Enum(OrderStatusEnum::class)],
            "address" => ["required", "string"],
            "city" => ["nullable", "string", "max:255"],
             "items" => "required|array",
            'items.*.product_id' => 'required|exists:products,id', // تحقق من وجود المنتج
            'items.*.quantity' => 'required|integer|min:1', // تحقق من الكمية
        ];
    }
}
