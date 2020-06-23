<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\ProductStatus;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

//User
$factory->define(User::class, function (Faker $faker) {
    return [
        'name'               => $faker->name,
        'email'              => $faker->unique()->safeEmail,
        'email_verified_at'  => now(),
        'password'           => '123456',
        'remember_token'     => Str::random(10),
        'verified'           => $verified = $faker->randomElement([UserStatus::VERIFIED, UserStatus::UNVERIFIED]),
        'verification_token' => $verified == UserStatus::VERIFIED ? null : User::generateVerificationCode(),
        'admin'              => $verified == UserStatus::UNVERIFIED ? UserType::REGULAR : $faker->randomElement([UserType::ADMIN, UserType::REGULAR]),
    ];
});

//Category
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->paragraph,
    ];
});

//Products
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->paragraph,
        'quantity'    => $faker->numberBetween(1, 10),
        'status'      => $faker->randomElement([ProductStatus::AVAILABLE, ProductStatus::UNAVAILABLE]),
        'image'       => $faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
        'seller_id'   => User::all()->random()->id,
    ];
});

//Transaction
$factory->define(Transaction::class, function (Faker $faker) {
    $seller = Seller::has('products')->get()->random();
    $buyer = User::all()->except($seller->id)->random();
    return [
        'quantity'   => $faker->numberBetween(1, 3),
        'buyer_id'   => $buyer->id,
        'product_id' => $seller->products->random()->id,
    ];
});