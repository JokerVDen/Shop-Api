<?php

namespace App\Http\Resources;

class UserResource extends Resource
{
    protected static $originalValues = [
        'identifier'   => 'id',
        'name'         => 'name',
        'email'        => 'email',
        'isVerified'   => 'verified',
        'isAdmin'      => 'admin',
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
            'links'        => [
                [
                    'rel'  => 'self',
                    'href' => route('users.show', $user->id),
                ],
            ],
        ];

    }
}
