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
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->except(['index']);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Transaction $transaction)
    {
        $categories = $this->service->getCategories($transaction);

        return  $this->jsonAll($categories);
    }
}
