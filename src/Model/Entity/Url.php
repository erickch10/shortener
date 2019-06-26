<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

use App\Utility\Base62;

use DOMDocument;
use DOMXPath;

/**
 * Url Entity
 *
 * @property int $id
 * @property string $long_url
 * @property string $short_url
 * @property int $visits
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Url extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'long_url' => true,
        'created' => true,
        'modified' => true
    ];

    protected function _setLongUrl($url)
    {
        $this->title = $url;
        return $url;
    }

    protected function _setShortUrl($url)
    {
        return Router::url("/$url", [
            '_base' => true,
        ]);
    }

    protected function _setTitle($url)
    {
        $doc = new DOMDocument();
        @$doc->loadHTMLFile($url);
        $xpath = new DOMXPath($doc);
        return $xpath->query('//title')->item(0)->nodeValue;
    }

    public function isShortUrlSet()
    {
        return !is_null($this->short_url);
    }

    public function setShortUrl()
    {
        $this->short_url = Base62::base62Encode($this->id);
    }
}
