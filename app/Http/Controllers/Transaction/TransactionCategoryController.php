<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use App\Services\Transaction\TransactionService;

class TransactionCategoryController extends ApiController
{
    /**
     * @var TransactionService
     */
    private $service;

    public function __construct(TransactionService $service)
    {

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Transaction $transaction)
    {
        $categories = $this->service->getCategories($transaction);

        return  $this->jsonAll($categories);
    }
}
