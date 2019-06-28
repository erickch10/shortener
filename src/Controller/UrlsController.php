<?php
namespace App\Controller;

use App\Model\Entity\Url;
use App\Utility\Base62;

/**
 * URLs controller
 *
 */
class UrlsController extends AppController
{
    /**
     * Receives a short URL, in case it's found, increments the visits and redirects
     *     to the corresponding long URL, if not, the table get method throws an exception
     *
     * @param string $shortUrl The generated short URL that will be parsed.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException in case the URL doesn't exist
     *     so that the framework converts it to a 404 error.
     * @return void
     */
    public function get($shortUrl)
    {
        $id = Url::getUrlIdFromShortUrl($shortUrl);
        $url = $this->Urls->get($id);
        $this->Urls->incrementVisits($url);
        $this->redirect($url->long_url, 302);
    }
}
