<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use App\Services\Seller\SellerService;

class SellerController extends ApiController
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sellers = $this->service->getAllSellers();
        return $this->jsonAll($sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Seller $seller)
    {
        return $this->jsonOne($seller);
    }
}
