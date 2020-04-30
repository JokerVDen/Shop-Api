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
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        $products = $this->service->getProducts($category);

        return $this->jsonAll($products);
    }

}
