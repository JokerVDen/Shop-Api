<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource implements HasOriginalValues
{
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
            'creationDate' => 'created_at',
            'lastChange'   => 'updated_at',
            'deleteDate'   => 'deleted_at',
        ];

        return $originalValues[$key] ?? null;
    }
}
