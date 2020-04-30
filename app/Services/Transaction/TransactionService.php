<?php


namespace App\Services\Transaction;


use App\Models\Transaction;

class TransactionService
{
    /**
     * @return Transaction[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllTransactions()
    {
        return Transaction::all();
    }
}