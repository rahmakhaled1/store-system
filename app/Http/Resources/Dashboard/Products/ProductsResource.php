<?php

namespace App\Http\Resources\Dashboard\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name ?? null,
            "section" => $this->section ?? null,
            "price_before_discount" => $this->price_before_discount ?? null,
            "price_after_discount" => $this->price_after_discount ?? null,
            "code" => $this->code ?? null,
            "image" => $this->imageLink ?? null,
            "status" => $this->status ?? null,
        ];
    }
}
