<?php

namespace App\Http\Resources;

class TransactionResource extends Resource
{
    protected static $originalValues = [
        'identifier'   => 'id',
        'quantity'     => 'quantity',
        'buyer'        => 'buyer_id',
        'product'      => 'product_id',
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
        $transaction = $this;
        return [
            'identifier'   => (int)$transaction->id,
            'quantity'     => (int)$transaction->quantity,
            'buyer'        => (int)$transaction->buyer_id,
            'product'      => (int)$transaction->product_id,
            'creationDate' => (string)$transaction->created_at,
            'lastChange'   => (string)$transaction->updated_at,
            'deleteDate'   => $transaction->when(isset($this->deleted_at), (string)$this->deleted_at),


            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show', $transaction->id),
                ],
                [
                    'rel' => 'transaction.categories',
                    'href' => route('transactions.categories.index', $transaction->id),
                ],
                [
                    'rel' => 'transaction.seller',
                    'href' => route('transactions.sellers.index', $transaction->id),
                ],
                [
                    'rel' => 'buyer',
                    'href' => route('buyers.show', $transaction->buyer_id),
                ],
                [
                    'rel' => 'product',
                    'href' => route('products.show', $transaction->product_id),
                ],
            ],
        ];
    }
}
