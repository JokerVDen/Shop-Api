<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this;
        return [
            'identifier'   => (int)$user->id,
            'name'         => (string)$user->name,
            'email'        => (string)$user->email,
            'isVerified'   => (int)$user->verified,
            'isAdmin'      => ($user->admin === 'true'),
            'creationDate' => (string)$user->created_at,
            'lastChange'   => (string)$user->updated_at,
            'deleteDate'   => $user->when(isset($this->deleted_at), (string)$this->deleted_at),
        ];
    }
}
