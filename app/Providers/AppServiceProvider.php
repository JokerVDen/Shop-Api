<?php

namespace App\Providers;

use App\Enums\ProductStatus;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Mail;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        User::created(function (User $user) {
            retry(5, function () use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            }, 100);
        });

        User::updated(function (User $user) {
            if ($user->isDirty('email'))
                retry(5, function () use ($user) {
                    Mail::to($user)->send(new UserMailChanged($user));
                }, 100);
        });

        Product::updated(function (Product $product) {
            if ($product->quantity == 0 && $product->isAvailable()) {
                $product->status = ProductStatus::UNAVAILABLE;
                $product->save();
            }
        });

    }
}
