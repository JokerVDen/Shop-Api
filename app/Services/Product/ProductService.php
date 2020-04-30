<?php


namespace App\Services\Product;


use App\Models\Product;

class ProductService
{
    /**
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllProducts()
    {
        return Product::all();
    }
}