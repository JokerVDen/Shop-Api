<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use App\Services\Seller\SellerService;

class SellerCategoryController extends ApiController
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Seller $seller)
    {
        $categories = $this->service->getCategories($seller);

        return $this->jsonAll($categories);
    }
}
