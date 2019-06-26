<?php
namespace App\Utility;

use DOMDocument;
use DOMXPath;
/**
 * Class to create manage URLs
 */
class Url
{
    public static function getTitle($url)
    {
        $doc = new DOMDocument();
        @$doc->loadHTMLFile($url);
        $xpath = new DOMXPath($doc);
        return $xpath->query('//title')->item(0)->nodeValue;
    }
}
