<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Products\ProductsRequest;
use App\Http\Requests\Dashboard\Products\StoreProductRequest;
use App\Http\Requests\Dashboard\Products\UpdateProductRequest;
use App\Http\Requests\General\FetchRequest;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function  __construct(protected ProductService $product_service){}
    public function fetch_product(FetchRequest $request)
    {
        return $this->product_service->fetch($request);
    }

    public function store_product(StoreProductRequest $request)
    {
        return $this->product_service->store($request);
    }

    public function show_product(ProductsRequest $request)
    {
        return $this->product_service->show($request);
    }

    public function update_product(UpdateProductRequest $request)
    {
        return $this->product_service->update($request);
    }

    public function delete_product(ProductsRequest $request)
    {
        return $this->product_service->delete($request);
    }
}
