<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use App\Services\Buyer\BuyerService;

class BuyerProductController extends ApiController
{

    /**
     * @var BuyerService
     */
    private $service;

    public function __construct(BuyerService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Buyer $buyer)
    {
        $products = $this->service->getProducts($buyer);

        return $this->jsonAll($products);
    }
}
