<?php

namespace App\Http\Resources;

class CategoryResource extends Resource
{
    protected static $originalValues = [
        'identifier'   => 'id',
        'title'        => 'name',
        'details'      => 'description',
        'creationDate' => 'created_at',
        'lastChange'   => 'updated_at',
        'deleteDate'   => 'deleted_at',
    ];

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $category = $this;
        return [
            'identifier'   => (int)$category->id,
            'title'        => (string)$category->name,
            'details'      => (string)$category->description,
            'creationDate' => (string)$category->created_at,
            'lastChange'   => (string)$category->updated_at,
            'deleteDate'   => $category->when(isset($this->deleted_at), (string)$this->deleted_at),

            'links' => [
                [
                    'rel'  => 'self',
                    'href' => route('categories.show', $category->id),
                ],
                [
                    'rel'  => 'category.buyers',
                    'href' => route('categories.buyers.index', $category->id),
                ],
                [
                    'rel'  => 'category.products',
                    'href' => route('categories.products.index', $category->id),
                ],
                [
                    'rel'  => 'category.sellers',
                    'href' => route('categories.sellers.index', $category->id),
                ],
                [
                    'rel'  => 'category.transactions',
                    'href' => route('categories.transactions.index', $category->id),
                ],
            ]
        ];
    }
}
