<?php


namespace App\Services\Buyer;


use App\Models\Buyer;
use App\Models\Product;

class BuyerService
{
    /**
     * @return Buyer[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllBuyers()
    {
        return Buyer::has('transactions')->get();
    }

    /**
     * @param int $id
     * @return Buyer|Buyer[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getBuyer(int $id)
    {
        return Buyer::has('transactions')->find($id);
    }

    /**
     * @param Buyer $buyer
     * @return \App\Models\Transaction[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getTransactions(Buyer $buyer)
    {
        return $buyer->transactions;
    }

    /**
     * @param Buyer $buyer
     * @return Product[]|\Illuminate\Support\Collection
     */
    public function getProducts(Buyer $buyer)
    {
        return $buyer
            ->transactions()
            ->with('product')
            ->get()
            ->pluck('product')
            ->unique('id')
            ->values();
    }

    /**
     * @param Buyer $buyer
     * @return \Illuminate\Support\Collection
     */
    public function getSellers(Buyer $buyer)
    {
        return $buyer->transactions()
            ->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();
    }

    public function getCategories(Buyer $buyer)
    {
        return $buyer->transactions()
            ->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()
            ->unique('id')
            ->values();
    }
}