<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

use App\Utility\Base62;
use App\Utility\Url as UrlUtility;

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
     * @var array
     */
    protected $_accessible = [
        'long_url' => true,
        'created' => true,
        'modified' => true
    ];

    /**
     * Mutator for the long_url field. Calls the setTitleFromUrl method.
     *
     * @param string $url The long URL.
     * @return string
     */
    protected function _setLongUrl($url)
    {
        $this->setTitleFromUrl($url);
        return $url;
    }

    /**
     * Mutator for the short_url field. Sets the URL with the full path.
     *
     * @param string $url The short URL.
     * @return string
     */
    protected function _setShortUrl($url)
    {
        return Router::url("/$url", [
            '_base' => true,
        ]);
    }

    /**
     * Sets the entity's title given a URL using the UrlUtility's getTitle method.
     *
     * @param string $url The URL to get the title from.
     * @return void
     */
    protected function setTitleFromUrl($url)
    {
        $this->title = UrlUtility::getTitle($url);
    }

    /**
     * Increments the entity's visits by a given number.
     *
     * @param int $step The number to increment the vists by.
     * @return void
     */
    public function incrementVisits($step = 1)
    {
        $this->visits += $step;
    }

    /**
     * Checks if the short URL has been set.
     *
     * @return bool
     */
    public function isShortUrlSet()
    {
        return !is_null($this->short_url);
    }

    /**
     * Sets the entity's short URL using the Base62's encode method.
     *
     * @return void
     */
    public function setShortUrl()
    {
        $this->short_url = Base62::encode($this->id);
    }

    /**
     * Gets the a URL's id given a short URL using the Base62's decode method.
     *
     * @param string $url The short URL to be parsed.
     * @return int
     */
    public static function getUrlIdFromShortUrl($shortUrl)
    {
        return Base62::decode($shortUrl);
    }
}
