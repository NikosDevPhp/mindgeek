<?php

namespace App\Utils;

use Illuminate\Support\Collection;

class Helpers
{


    public static function addPropertyToCollectionOfObjects(Collection &$items, string $key, mixed $value): void
    {
        $items->map(function ($item) use ($key, $value) {
            $item->$key = $value;
            return $item;
        });
    }

    public static function stringToUtf8(string $string): string
    {
        return utf8_encode($string);
    }

    public static function generateUniqIdFromImageUrl(string $url): string
    {
        $array = explode('.', $url);
        $imageType = end($array);
        return uniqid() . $imageType;
    }

}
