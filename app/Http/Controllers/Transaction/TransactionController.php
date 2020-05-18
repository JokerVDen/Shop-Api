<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use App\Services\Transaction\TransactionService;

class TransactionController extends ApiController
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index()
    {
        $transactions = $this->service->getAllTransactions();

        return $this->jsonAll($transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Transaction $transaction)
    {
        return $this->jsonOne($transaction);
    }
}
