<?php
namespace App\Controller\Api;

use Crud\Controller\ControllerTrait;

use App\Controller\AppController as Controller;

class AppController extends Controller
{
    use ControllerTrait;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
          'actions' => [
            'Crud.Add',
            'Crud.View',
            'all' => [
              'className' => '\App\Controller\Crud\Action\AllAction',
            ],
          ],
          'listeners' => ['Crud.Api'],
        ]);
    }
}
