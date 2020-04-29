<?php


namespace App\Services\Buyer;


use App\Models\Buyer;

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
}