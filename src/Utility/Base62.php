<?php
namespace App\Utility;

/**
 * Base 62 parser class
 */
class Base62
{
    const CHARS = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    /**
     * Decodes a base 62 string to an integer.
     *
     * @param string $base62 The base 62 string.
     * @return int
     */
    public static function decode($base62)
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

    /**
     * Encodes an integer into a base 62 string.
     *
     * @param int $base10 The integer value.
     * @return string
     */
    public static function encode($base10)
    {
        return implode(
          array_map([self::class, 'extractChar'],
          array_reverse(self::getDigits($base10)))
        );
    }

    /**
     * Gets the base 62 characters indexes from an integer-
     *
     * @param int $base10 The integer value.
     * @return array
     */
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

    /**
     * Gets the base 62 character from an index-
     *
     * @param int $index Char index.
     * @return string
     */
    protected static function extractChar($index)
    {
        return self::CHARS[intval($index)];
    }

    /**
     * Get the base 62 char value for the conversion.
     *
     * @param string $char Base 62 character.
     * @param int $index Char index.
     * @return int
     */
    protected static function decodeChar($char, $index)
    {
        return strpos(self::CHARS, $char) * pow(62, $index);
    }

    /**
     * Accumulates the factors dsuring the conversion.
     *
     * @param int $total Accumulate dvalue.
     * @param int $el Char conversion value.
     * @return int
     */
    protected static function accumulate($total, $el)
    {
        $total += $el;
        return $total;
    }
}
