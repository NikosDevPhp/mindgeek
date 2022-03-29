<?php

namespace App\Utils;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Helpers
{

    /**
     * Adds a property on each object of a collection
     * @param Collection $items
     * @param string $key
     * @param mixed $value
     */
    public static function addPropertyToCollectionOfObjects(Collection &$items, string $key, mixed $value): void
    {
        $items->map(function ($item) use ($key, $value) {
            $item->$key = $value;
            return $item;
        });
    }

    /**
     * Calls utf8_encode on string
     * @param string $string
     * @return string
     */
    public static function stringToUtf8(string $string): string
    {
        // TODO: check if any other transformation is needed
        // replace u+fffd https://www.compart.com/en/unicode/U+FFFD
        // $string = preg_replace('@\x{FFFD}@u', '', $string);
        return utf8_encode($string);
    }

    /**
     * Uses md5 to avoid hashing with different salts in Laravel
     * @param string $url
     * @return string
     */
    public static function generateUniqIdFromImageUrl(string $url): string
    {
        try {
            $md5 = md5($url);
            $array = explode('.', $url);
            $imageType = end($array);
            return $md5 . '.' . $imageType;
        } catch (\Exception $e) {
            Log::error('Invalid url string');
        }
    }

    /**
     * Removes specified keyword from string
     * @param string $string
     * @param string $keyword
     * @return string
     */
    public static function removeKeywordFromString(string $string, string $keyword): string
    {
        return str_replace($keyword, '', $string);
    }

}
