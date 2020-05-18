<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

abstract class Resource extends JsonResource implements HasOriginalValues
{
    /**
     * @param string $key
     * @return string|null
     */
    public static function originalAttribute(string $key): ?string
    {
        return static::$originalValues[$key] ?? null;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public static function transformedAttribute(string $key): ?string
    {
        $flipOriginalValues = array_flip(static::$originalValues);
        return $flipOriginalValues[$key] ?? null;
    }
}