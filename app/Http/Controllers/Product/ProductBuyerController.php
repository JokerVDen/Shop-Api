<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Services\Product\ProductService;

class ProductBuyerController extends ApiController
{
    /**
     * @var ProductService
     */
    private $service;

    public function __construct(ProductService $service)
    {

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Product $product)
    {
        $buyers = $this->service->getBuyers($product);

        return $this->jsonAll($buyers);
    }
}
