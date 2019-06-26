<?php
namespace App\Controller;

use App\Utility\Base62;

class UrlsController extends AppController
{
    public function get($shortUrl)
    {
        $id = $this->getUrlId($shortUrl);
        $url = $this->Urls->get($id);
	$this->incrementVisits($url);
        $this->redirect($url->long_url, 302);
    }

    protected function getUrlId($shortUrl)
    {
        return Base62::decode($shortUrl);
    }

    protected function incrementVisits($url)
    {
        $url->incrementVisits();
        $this->Urls->save($url);
    }

}
