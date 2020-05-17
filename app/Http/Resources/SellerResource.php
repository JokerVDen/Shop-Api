<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $seller = $this;
        return [
            'identifier'   => (int)$seller->id,
            'name'         => (string)$seller->name,
            'email'        => (string)$seller->email,
            'isVerified'   => (int)$seller->verified,
            'creationDate' => (string)$seller->created_at,
            'lastChange'   => (string)$seller->updated_at,
            'deleteDate'   => $seller->when(isset($this->deleted_at), (string)$this->deleted_at),
        ];
    }
}
