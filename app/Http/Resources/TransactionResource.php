<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $transaction = $this;
        return [
            'identifier' => (int)$transaction->id,
            'quantity'  => (int)$transaction->quantity,
            'buyer'  => (int)$transaction->buyer_id,
            'product'  => (int)$transaction->product_id,
            'creationDate' => (string)$transaction->created_at,
            'lastChange'   => (string)$transaction->updated_at,
            'deleteDate'   => $transaction->when(isset($this->deleted_at), (string)$this->deleted_at),
        ];
    }
}
