<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource implements HasOriginalValues
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $product = $this;
        return [
            'identifier'   => (int)$product->id,
            'title'        => (string)$product->name,
            'details'      => (string)$product->description,
            'stock'        => (int)$product->quantity,
            'situation'    => (string)$product->status,
            'picture'      => url('img/' . $product->image),
            'seller'       => (int)$product->seller_id,
            'creationDate' => (string)$product->created_at,
            'lastChange'   => (string)$product->updated_at,
            'deleteDate'   => $product->when(isset($this->deleted_at), (string)$this->deleted_at),
        ];
    }

    /**
     * @param string $key
     * @return string|null
     */
    public static function originalAttribute(string $key): ?string
    {
        $originalValues = [
            'identifier'   => 'id',
            'title'        => 'name',
            'details'      => 'description',
            'stock'        => 'quantity',
            'situation'    => 'status',
            'picture'      => 'image',
            'seller'       => 'seller_id',
            'creationDate' => 'created_at',
            'lastChange'   => 'updated_at',
            'deleteDate'   => 'deleted_at',
        ];

        return $originalValues[$key] ?? null;
    }
}
