<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends ApiController
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = $this->service->getAllCategory();

        return $this->jsonAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = $this->service->storeCategory($request->all());

        return $this->jsonOne($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->jsonOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $category = $this->service->updateCategory($category, $request->all());

        return $this->jsonOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return  $this->jsonOne($category);
    }
}
