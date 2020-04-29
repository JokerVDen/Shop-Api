<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use App\Services\Buyer\BuyerService;

class BuyerController extends ApiController
{

    /**
     * @var BuyerService
     */
    private $service;

    public function __construct(BuyerService $service)
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
        $buyers = $this->service->getAllBuyers();
        return $this->jsonAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Buyer $buyer)
    {
        return $this->jsonOne($buyer);
    }
}
