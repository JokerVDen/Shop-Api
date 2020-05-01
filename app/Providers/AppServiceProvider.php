<?php

namespace App\Providers;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        Product::updated(function(Product $product){
            if ($product->quantity == 0 && $product->isAvailable()) {
                $product->status = ProductStatus::UNAVAILABLE;
                $product->save();
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
