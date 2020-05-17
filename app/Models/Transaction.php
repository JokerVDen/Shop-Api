<?php

namespace App\Models;

use App\Http\Resources\TransactionResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public $resourceClass = TransactionResource::class;

    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id',
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
