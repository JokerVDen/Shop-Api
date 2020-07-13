<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Services\Product\ProductService;

class ProductController extends ApiController
{
    /**
     * @var ProductService
     */
    private $service;

    public function __construct(ProductService $service)
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index()
    {
        $products = $this->service->getAllProducts();

        return $this->jsonAll($products);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return $this->jsonOne($product);
    }
}
