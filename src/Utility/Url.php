<?php
namespace App\Utility;

use DOMDocument;
use DOMXPath;

/**
 * Class to operate URLs
 */
class Url
{
    /**
     * Gets the title from a given URL.
     * @param string $url The url to get the title from.
     * @return string
     */
    public static function getTitle($url)
    {
        $doc = new DOMDocument();
        @$doc->loadHTMLFile($url);
        $xpath = new DOMXPath($doc);
        return $xpath->query('//title')->item(0)->nodeValue;
    }
}
