<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Products\ProductsRequest;
use App\Http\Resources\Dashboard\Products\ProductsResource;
use App\Models\Products;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;

    public function fetch_products()
    {
        $products = Products::latest()->paginate(10);
        if ($products) {
            $message = "Products data has been successfully retrieved.";
            return self::dataSuccess(ProductsResource::collection($products), $message);
        } else {
            return self::dataFail("Products data could not be retrieved.");
        }

    }

    public function show_product(ProductsRequest $request)
    {
        $data = $request->validated();
        $product = Products::findOrFail($data["product_id"]);
        $message = "Product data has been successfully retrieved.";
        return self::dataSuccess(new ProductsResource($product), $message);
    }

}
