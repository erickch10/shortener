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
        $this->setTitleFromUrl($url);
        return $url;
    }

    protected function _setShortUrl($url)
    {
        return Router::url("/$url", [
            '_base' => true,
        ]);
    }

    public function incrementVisits()
    {
        $this->visits += 1;
    }

    public function isShortUrlSet()
    {
        return !is_null($this->short_url);
    }

    public function setShortUrl()
    {
        $this->short_url = Base62::encode($this->id);
    }

    protected function setTitleFromUrl($url)
    {
        $this->title = UrlUtility::getTitle($url);
    }
}
