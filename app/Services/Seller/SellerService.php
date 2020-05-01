<?php


namespace App\Services\Seller;


use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerService
{
    /**
     * @return Seller[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllSellers()
    {
        return Seller::has('products')->get();
    }

    /**
     * @param Seller $seller
     * @return \Illuminate\Support\Collection
     */
    public function getTransactions(Seller $seller)
    {
        return $seller
            ->products()
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->unique('id')
            ->values();
    }

    /**
     * @param Seller $seller
     * @return \Illuminate\Support\Collection
     */
    public function getBuyers(Seller $seller)
    {
        return $seller
            ->products()
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();
    }

    /**
     * @param Seller $seller
     * @return \Illuminate\Support\Collection
     */
    public function getCategories(Seller $seller)
    {
        return $seller
            ->products()
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique('id')
            ->values();
    }

    /**
     * @param Seller $seller
     * @return \Illuminate\Support\Collection
     */
    public function getProducts(Seller $seller)
    {
        return $seller
            ->products
            ->unique('id');
    }

    /**
     * @param User $seller
     * @param array $data
     * @return Product|\Illuminate\Database\Eloquent\Model
     */
    public function createSellersProduct(User $seller, array $data)
    {
        $data = array_merge($data, [
            'status'    => ProductStatus::UNAVAILABLE,
            'image'     => '1.jpg',
            'seller_id' => $seller->id,
        ]);

        return Product::create($data);
    }

    /**
     * @param Seller $seller
     * @param Product $product
     * @param array $data
     * @return Product
     */
    public function updateSellersProduct(Seller $seller, Product $product, array $data)
    {
        $dataCollection = collect($data);

        $this->checkSeller($seller, $product);

        $product->fill($dataCollection->only([
            'name',
            'description',
            'quantity'
        ])->toArray());

        if ($dataCollection->has('status')) {
            $product->status = $dataCollection->get('status');
            if($product->isAvailable() && $product->categories()->count() == 0)
                throw new HttpException(409, __('seller/error.product_must_have_at_least_one_category'));
        }

        if ($product->isClean())
            throw new HttpException(422, __('errors.need_to_specify_a_different_values'));

        $product->save();

        return $product;
    }

    /**
     * @param Seller $seller
     * @param Product $product
     * @return Product
     * @throws \Exception
     */
    public function deleteProduct(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->delete();

        return $product;
    }

    /**
     * @param Seller $seller
     * @param Product $product
     */
    protected function checkSeller(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id)
            throw new HttpException(422, __('seller/error.this_user_is_not_a_seller_of_this_product'));
    }
}