<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Services\Category\CategoryService;

class CategorySellerController extends ApiController
{

    /**
     * @var CategoryService
     */
    private $service;

    public function __construct(CategoryService $service)
    {
        parent::__construct();
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
        $seller = $this->service->getSellers($category);

        return $this->jsonAll($seller);
    }

}
