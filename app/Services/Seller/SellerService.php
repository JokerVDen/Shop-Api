<?php


namespace App\Services\Seller;


use App\Models\Seller;

class SellerService
{
    /**
     * @return Seller[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllSellers()
    {
        return Seller::has('products')->get();
    }
}