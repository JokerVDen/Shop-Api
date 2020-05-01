<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Services\Seller\SellerService;

class SellerProductController extends ApiController
{
    /**
     * @var SellerService
     */
    private $service;

    public function __construct(SellerService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        $products = $this->service->getProducts($seller);

        return $this->jsonAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @param User $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductStoreRequest $request, User $seller)
    {
        $product = $this->service->createSellersProduct($seller, $request);

        return $this->jsonOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param \App\Models\Seller $seller
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \HttpException
     */
    public function update(ProductUpdateRequest $request, Seller $seller, Product $product)
    {
        $product = $this->service->updateSellersProduct($seller, $product, $request);

        return $this->jsonOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Seller $seller
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Seller $seller, Product $product)
    {
        $product = $this->service->deleteProduct($seller, $product);

        return $this->jsonOne($product);
    }
}
