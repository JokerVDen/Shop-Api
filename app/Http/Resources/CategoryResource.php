<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category = $this;
        return [
            'identifier' => (int)$category->id,
            'title' => (string)$category->name,
            'details' => (string)$category->description,
            'creationDate' => (string)$category->created_at,
            'lastChange'   => (string)$category->updated_at,
            'deleteDate'   => $category->when(isset($this->deleted_at), (string)$this->deleted_at),
        ];
    }
}
