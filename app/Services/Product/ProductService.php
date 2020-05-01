<?php


namespace App\Services\Product;


use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductService
{
    /**
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllProducts()
    {
        return Product::all();
    }

    /**
     * @param Product $product
     * @return \Illuminate\Support\Collection
     */
    public function getBuyers(Product $product)
    {
        return $product
            ->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique('id')
            ->values();
    }

    /**
     * @param Product $product
     * @return \Illuminate\Support\Collection
     */
    public function getCategories(Product $product)
    {
        return $product->categories;
    }

    /**
     * @param Product $product
     * @return \Illuminate\Support\Collection
     */
    public function getTransactions(Product $product)
    {
        return $product->transactions;
    }

    /**
     * @param Product $product
     * @param Category $category
     * @return Category[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function updateProductsCategory(Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching($category->id);

        return $product->categories;
    }

    /**
     * @param Product $product
     * @param Category $category
     * @return Category[]|\Illuminate\Database\Eloquent\Collection|mixed
     * @throws HttpException
     */
    public function deleteCategory(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id))
            throw new HttpException(409, __('category_not_of_this_product'));

        $product->categories()->detach($category->id);

        return $product->categories;
    }

    public function createTransaction(Product $product, User $buyer, array $data)
    {
        if ($buyer->id == $product->seller_id)
            throw new HttpException(409, __('The buyer must be different then seller!'));

        if (!$buyer->isVerified())
            throw new HttpException(409, __('The buyer must be a verified user!'));

        if (!$product->seller->isVerified())
            throw new HttpException(409, __('The seller must be a verified user!'));

        if (!$product->isAvailable())
            throw new HttpException(409, __('The product is not available!'));

        if ($product->quantity < $data['quantity'])
            throw new HttpException(409, __('The product quantity is less then you required!'));

        return DB::transaction(function () use ($product, $buyer, $data) {
            $product->quantity -= $data['quantity'];
            $product->save();

            return Transaction::create([
                'quantity'   => $data['quantity'],
                'buyer_id'   => $buyer->id,
                'product_id' => $product->id,
            ]);
        });
    }
}