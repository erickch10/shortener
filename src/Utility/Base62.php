<?php
namespace App\Utility;
/**
 * Class to create manage URLs
 */
class Base62
{
    const CHARS = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    public static function base62Decode($base62)
    {
        $chars = array_reverse(str_split($base62));

        return array_reduce(
          array_map(
            [self::class, 'decodeChar'],
            $chars,
            array_keys($chars)
          ),
          [self::class, 'accumulate']
        );
    }

    public static function base62Encode($base10)
    {
        return implode(
          array_map([self::class, 'extractChar'],
          array_reverse(self::getDigits($base10)))
        );
    }

    protected static function getDigits($base10)
    {
        $digits = [];
        $number = $base10;

        while($number > 62) {
            $remainder = $number%62;

            $digits[] = $remainder;

            $number = floor($number/62);
        }

        $digits[] = $number;

        return $digits;
    }

    protected static function extractChar($index)
    {
        return self::CHARS[intval($index)];
    }

    protected static function decodeChar($char, $index)
    {
        return strpos(self::CHARS, $char) * pow(62, $index);
    }

    protected static function accumulate($total, $el)
    {
        $total += $el;
        return $total;
    }
}
