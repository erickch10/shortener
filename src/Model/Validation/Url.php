<?php
namespace App\Model\Validation;

use Cake\Validation\Validator;

/**
 * Url validations provider
 *
 */
class Url extends Validator
{
    /**
     * Checks if a given URl returns a valid response.
     *
     * @param string $url URL to be checked.
     * @param array $context Validation context.
     * @return bool
     */
    public static function urlExists($url, array $context) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }
}
