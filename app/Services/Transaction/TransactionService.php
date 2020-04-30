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

    /**
     * @param Transaction $transaction
     * @return \App\Models\Category[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getCategories(Transaction $transaction)
    {
        return $transaction->product->categories;
    }

    /**
     * @param Transaction $transaction
     * @return \App\Models\Seller|mixed
     */
    public function getSeller(Transaction $transaction)
    {
        return $transaction->product->seller;
    }
}