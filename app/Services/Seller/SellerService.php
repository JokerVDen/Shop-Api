<?php


namespace App\Services\Seller;


use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Storage;
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
     * @param FormRequest $request
     * @return Product|\Illuminate\Database\Eloquent\Model
     */
    public function createSellersProduct(User $seller, FormRequest $request)
    {
        $data = array_merge($request->all(), [
            'status'    => ProductStatus::UNAVAILABLE,
            'image'     => $request->file('image')->store(''),
            'seller_id' => $seller->id,
        ]);

        return Product::create($data);
    }

    /**
     * @param Seller $seller
     * @param Product $product
     * @param FormRequest $request
     * @return Product
     */
    public function updateSellersProduct(Seller $seller, Product $product, FormRequest $request)
    {
        $this->checkSeller($seller, $product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity'
        ]));

        if ($request->has('status')) {
            $product->status = $request->get('status');
            if($product->isAvailable() && $product->categories()->count() == 0)
                throw new HttpException(409, __('seller/error.product_must_have_at_least_one_category'));
        }

        if($request->hasFile('image')) {
            Storage::delete($product->image);
            $image = $request->file('image')->store('');
            $product->image = $image;
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
        Storage::delete($product->image);

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