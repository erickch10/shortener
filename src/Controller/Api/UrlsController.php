<?php
namespace App\Controller\Api;

use Cake\Event\Event;

class UrlsController extends AppController
{
    public function add()
    {
        $this->Crud->action()->config('api.success.data.entity', [
          'id',
          'long_url',
          'short_url',
          'title',
          'visits',
          'created',
          'modified',
        ]);

        if ($url = $this->getUrlFromDB()) {
            return $this->Crud->execute('view', ['id' => $url->id]);
        } else {
            return $this->Crud->execute();
        }
    }

    public function beforeFilter(Event $event)
    {
        $this->Crud->mapAction(
            'topVisited',
            '\App\Controller\Crud\Action\TopVisited'
        );
    }

    protected function getUrlFromDB()
    {
        if ($longUrl = $this->request->getData('long_url')) {
            return $this->Urls->findByLongUrl($longUrl)
                ->select(['id'])
                ->first();
        }
    }
}
