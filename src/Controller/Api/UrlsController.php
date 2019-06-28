<?php
namespace App\Controller\Api;

/**
 * URLs API controller
 *
 */
class UrlsController extends AppController
{
    // Url attributes to be returned after creating one.
    protected $urlAttrs = [
      'id',
      'long_url',
      'short_url',
      'title',
      'visits',
      'created',
      'modified',
    ];

    protected $customActions = [
      'topVisited' => '\App\Controller\Crud\Action\TopVisited',
    ];

    /**
     * API Url Add method. Checks if the URl exists and calls the API Get method if os, otherwise
     *     call the Add method.
     *
     * @return \Cake\Http\Response
     */
    public function add()
    {
        $this->Crud->action()->config('api.success.data.entity', $this->urlAttrs);

        if ($url = $this->getUrlFromDB()) {
            return $this->Crud->execute('view', ['id' => $url->id]);
        } else {
            return $this->Crud->execute();
        }
    }

    /**
     * Returns the URL received in the request from the database in case it already exists.
     *     Only the id is retrieved since thats what the view action needs.
     *
     * @return \App\Model\Entity\Url|null
     */
    protected function getUrlFromDB()
    {
        if ($longUrl = $this->request->getData('long_url')) {
            return $this->Urls->findByLongUrl($longUrl)
                ->select(['id'])
                ->first();
        }
    }
}
