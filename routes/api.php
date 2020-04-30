<?php

//Buyers
Route::apiResource('buyers', 'Buyer\BuyerController')->only(['index', 'show']);
Route::apiResource('buyers.transactions', 'Buyer\BuyerTransactionController')->only(['index']);
Route::apiResource('buyers.products', 'Buyer\BuyerProductController')->only(['index']);
Route::apiResource('buyers.sellers', 'Buyer\BuyerSellerController')->only(['index']);
Route::apiResource('buyers.categories', 'Buyer\BuyerCategoryController')->only(['index']);

//Categories
Route::apiResource('categories', 'Category\CategoryController');

//Products
Route::apiResource('products', 'Product\ProductController')->only(['index', 'show']);

//Sellers
Route::apiResource('sellers', 'Seller\SellerController')->only(['index', 'show']);

//Transactions
Route::apiResource('transactions', 'Transaction\TransactionController')->only(['index', 'show']);
Route::apiResource('transactions.categories', 'Transaction\TransactionCategoryController')->only(['index']);
Route::apiResource('transactions.sellers', 'Transaction\TransactionSellerController')->only(['index']);

//Users
Route::apiResource('users', 'User\UserController');