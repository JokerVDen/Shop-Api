<?php


namespace App\Http\Resources;


interface HasOriginalValues
{
    /**
     * @param string $key
     * @return string|null
     */
    public static function originalAttribute(string $key): ?string;
}