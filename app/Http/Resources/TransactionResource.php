<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource implements HasOriginalValues
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $transaction = $this;
        return [
            'identifier'   => (int)$transaction->id,
            'quantity'     => (int)$transaction->quantity,
            'buyer'        => (int)$transaction->buyer_id,
            'product'      => (int)$transaction->product_id,
            'creationDate' => (string)$transaction->created_at,
            'lastChange'   => (string)$transaction->updated_at,
            'deleteDate'   => $transaction->when(isset($this->deleted_at), (string)$this->deleted_at),
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
            'quantity'     => 'quantity',
            'buyer'        => 'buyer_id',
            'product'      => 'product_id',
            'creationDate' => 'created_at',
            'lastChange'   => 'updated_at',
            'deleteDate'   => 'deleted_at',
        ];

        return $originalValues[$key] ?? null;
    }
}
