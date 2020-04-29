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

    /**
     * @param int $id
     * @return Seller|Seller[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getSeller(int $id)
    {
        return Seller::has('products')->find($id);
    }
}