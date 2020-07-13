<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Transaction\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Product;
use App\Models\User;
use App\Services\Product\ProductService;

class ProductBuyerTransactionController extends ApiController
{
    /**
     * @var ProductService
     */
    private $service;

    public function __construct(ProductService $service)
    {
        parent::__construct();
        $this->middleware('transform.resource.input:' . TransactionResource::class)
            ->only(['store']);
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionStoreRequest $request
     * @param Product $product
     * @param User $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TransactionStoreRequest $request, Product $product, User $buyer)
    {
        $transaction = $this->service->createTransaction($product, $buyer, $request->all());

        return $this->jsonOne($transaction);
    }
}
