<?php

namespace App\Http\Resources\Dashboard\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "status" => $this->status,
            "total_before_delivery" => $this->total_before_delivery,
            "total_after_delivery" => $this->total_after_delivery,
            "username" => $this->username,
            "phone" => $this->phone,
            "city" => $this->city,
            "address" => $this->address,
            "governorate_id" =>$this->governorate_id,
        ];
    }
}
