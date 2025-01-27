<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Order\StoreOrderRequest;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function __construct(protected OrderService $order_service){}

    public function store_order(StoreOrderRequest $request)
    {
        return $this->order_service->store($request);
    }

}
