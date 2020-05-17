<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuyerResource extends JsonResource implements HasOriginalValues
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $buyer = $this;
        return [
            'identifier'   => (int)$buyer->id,
            'name'         => (string)$buyer->name,
            'email'        => (string)$buyer->email,
            'isVerified'   => (int)$buyer->verified,
            'creationDate' => (string)$buyer->created_at,
            'lastChange'   => (string)$buyer->updated_at,
            'deleteDate'   => $buyer->when(isset($this->deleted_at), (string)$this->deleted_at),
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
            'name'         => 'name',
            'email'        => 'email',
            'isVerified'   => 'verified',
            'creationDate' => 'created_at',
            'lastChange'   => 'updated_at',
            'deleteDate'   => 'deleted_at',
        ];

        return $originalValues[$key] ?? null;
    }
}
