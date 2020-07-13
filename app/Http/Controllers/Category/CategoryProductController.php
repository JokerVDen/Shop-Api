<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Services\Category\CategoryService;

class CategoryProductController extends ApiController
{

    /**
     * @var CategoryService
     */
    private $service;

    public function __construct(CategoryService $service)
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->except(['index']);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Category $category)
    {
        $products = $this->service->getProducts($category);

        return $this->jsonAll($products);
    }

}
