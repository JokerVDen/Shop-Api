<?php

namespace App\Models;

use App\Http\Resources\BuyerResource;
use App\Scopes\BuyerScope;

class Buyer extends User
{
    public $resourceClass = BuyerResource::class;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope());
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
