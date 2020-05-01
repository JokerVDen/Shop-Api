<?php


namespace App\Services\Category;


use App\Models\Category;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CategoryService
{
    /**
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategory()
    {
        return Category::all();
    }

    /**
     * @param $data
     * @return Category|\Illuminate\Database\Eloquent\Model
     */
    public function storeCategory($data)
    {
        return Category::create($data);
    }

    /**
     * @param Category $category
     * @param array $data
     * @return Category
     */
    public function updateCategory(Category $category, array $data)
    {
        $category->fill($data);

        if (!$category->isDirty())
            throw new HttpException(422, 'errors.need_to_specify_a_different_values');

        $category->save();

        return $category;
    }

    /**
     * @param Category $category
     * @return \Illuminate\Support\Collection
     */
    public function getProducts(Category $category)
    {
        return $category
            ->products
            ->unique('id')
            ->values();
    }

    /**
     * @param Category $category
     * @return \Illuminate\Support\Collection
     */
    public function getSellers(Category $category)
    {
        return $category
            ->products()
            ->with('seller')
            ->get()
            ->pluck('seller')
            ->unique('id')
            ->values();
    }

    /**
     * @param Category $category
     * @return \Illuminate\Support\Collection
     */
    public function getTransactions(Category $category)
    {
        return $category
            ->products()
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->unique('id')
            ->values();
    }

    /**
     * @param Category $category
     * @return \Illuminate\Support\Collection
     */
    public function getBuyers(Category $category)
    {
        return $category
            ->products()
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();
    }
}