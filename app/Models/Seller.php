<?php

namespace App\Models;

use App\Http\Resources\SellerResource;
use App\Scopes\SellerScope;

class Seller extends User
{
    public $resourceClass = SellerResource::class;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope());
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
