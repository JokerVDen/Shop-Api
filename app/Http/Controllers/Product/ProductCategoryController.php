<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use App\Services\Product\ProductService;
use Request;

class ProductCategoryController extends ApiController
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
     */
    public function index(Product $product)
    {
        $categories = $this->service->getCategories($product);

        return $this->jsonAll($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, Category $category)
    {
        $categories = $this->service->updateProductsCategory($product, $category);

        return $this->jsonAll($categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \HttpException
     */
    public function destroy(Product $product, Category $category)
    {
        $categories = $this->service->deleteCategory($product, $category);

        return $this->jsonAll($categories);
    }
}
