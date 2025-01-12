<?php

namespace App\Services\Product;


use App\Helpers\ImageHelper;
use App\Http\Requests\Dashboard\Products\ProductsRequest;
use App\Http\Requests\Dashboard\Products\StoreProductRequest;
use App\Http\Requests\Dashboard\Products\UpdateProductRequest;
use App\Http\Requests\General\FetchRequest;
use App\Http\Resources\Dashboard\Products\ProductsResource;
use App\Models\Products;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;

class ProductService
{
    use ResponseTrait;
    public function fetch(FetchRequest $request)
    {
        $data = $request->validated();
        try {
            $products = Products::search($data)->paginate(15);
            if ($products) {
                $message = "Products data has been successfully retrieved.";
               return self::dataSuccess(ProductsResource::collection($products), $message);
            } else {
                return self::dataFail("Products data could not be retrieved.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        try {
            if ($request->hasFile("image")) {
                $data["image"] = ImageHelper::uploadImage($request->file("image"), "products");
            }
            $product = Products::create($data);
            if ($product) {
                $message = "The Product has been successfully stored.";
                return self::dataSuccess(new ProductsResource($product), $message);
            } else {
                return self::dataFail("The Product could not be stored.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function update(UpdateProductRequest $request)
    {
        $data = $request->validated();
        $product = Products::find($data["product_id"]);

        if (!$product) {
            return self::dataFail("Product not found.");
        }
        try {
            if ($request->hasFile("image")) {
                if ($product->image) {
                    ImageHelper::deleteImage($product->image);
                }
                $data["image"] = ImageHelper::uploadImage($request->file("image"), "products");
            }
            $product->update($data);

            $message = "The Product has been successfully updated.";
            return self::dataSuccess(new ProductsResource($product), $message);
        } catch (\Exception $e) {
            Log::error('Product Update Error: ' . $e->getMessage());

            return self::dataFail("An error occurred while updating the product.");
        }
    }

    public function show(ProductsRequest $request)
    {
        $data = $request->validated();
        $product = Products::find($data["product_id"]);
        try {
            if ($product) {
                $message = "Product data has been successfully retrieved.";
                return self::dataSuccess(new ProductsResource($product), $message);
            } else {
                return self::dataFail("Product data could not be retrieved.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }

    public function delete(ProductsRequest $request)
    {
        $data = $request->validated();
        try {
            $product = Products::find($data["product_id"]);
            $product->delete();
            if ($product){
                $message = "The Product has been successfully deleted.";
                return self::dataSuccess(new ProductsResource($product), $message);
            }else{
                return self::dataFail("The Product could not be deleted.");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }



}
