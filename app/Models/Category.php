<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $resourceClass = CategoryResource::class;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'pivot',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
