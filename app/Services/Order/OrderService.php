<?php

namespace App\Services\Order;

use App\Http\Requests\Dashboard\Order\ChangeOrderStatusRequest;
use App\Http\Requests\Dashboard\Order\OrderRequest;
use App\Http\Requests\Website\Order\StoreOrderRequest;
use App\Http\Resources\Dashboard\Order\OrderResource;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\Setting;

class OrderService
{
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        // إنشاء الطلب
        $order = Order::create([
            "username" => $data["username"],
            "phone" => $data["phone"],
            "governorate_id" => $data["governorate_id"],
            "total_before_delivery" => 0, // سيتم تحديثه لاحقًا
            "total_after_delivery" => 0, // سيتم تحديثه لاحقًا
            "code" => $data["code"],
            "city" => $data["city"],
            "address" => $data["address"],
        ]);

        $totalBeforeDelivery = 0;

        // إضافة العناصر إلى الطلب
        foreach ($data["items"] as $item) {
            $product = Products::find($item['product_id']);

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price_after_discount ?? $product->price,
            ]);

            $totalBeforeDelivery += ($product->price_after_discount ?? $product->price) * $item['quantity'];
        }

        // حساب تكلفة التوصيل بناءً على المحافظة
        $governorate = Governorate::findOrFail($order->governorate_id);
        $deliveryCost = Setting::where('governorate_id', $governorate->id)->value('delivery');

        // حساب المبلغ الإجمالي بعد التوصيل
        $totalAfterDelivery = $totalBeforeDelivery + $deliveryCost;

        // تحديث المبالغ في الطلب
        $order->update([
            'total_before_delivery' => $totalBeforeDelivery,
            'total_after_delivery' => $totalAfterDelivery,
        ]);

        return response()->json([
            'message' => 'The Order has been successfully stored.',
            'order' => $order->load('items.product'),
        ], 201);
    }

    public function fetch()
    {
        $orders = Order::with("items","governorate")->latest()->paginate(10);
        if ($orders){
            return response()->json([
               "status" => true,
               "message"=>"Orders data has been successfully retrieved.",
                "data" => $orders
            ]);
        }
        return response()->json([
            "status" => false,
            "message"=>"Not found orders to retrieved.",
        ]);
    }

    public function show(OrderRequest $request)
    {
        $data = $request->validated();
        $order = Order::findOrFail($data["order_id"])->load("items","governorate");
        if(!$order){
            return response()->json([
                "status"=>false,
                "message" => "This order not found"
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "Order data has been successfully retrieved.",
            "data" => new OrderResource($order)
        ]);
    }

    public function delete(OrderRequest $request)
    {
        $data = $request->validated();
        $order = Order::findOrFail($data["order_id"]);
        if(!$order){
            return response()->json([
                "status"=>false,
                "message" => "This order not found"
            ]);
        }
        $order->delete();
        return response()->json([
            "status" => true,
            "message" => "Order has been deleted.",

        ]);
    }

    public function change_order_status(ChangeOrderStatusRequest $request)
    {
        $data = $request->validated();
        $order = Order::findOrFail($data["order_id"]);
        $order->status = $data["status"];
        $order->save();
        return response()->json([
            "status" => true,
            "message" => "The product status has been successfully changed.",
            "data" => $order,
        ]);
    }


}
