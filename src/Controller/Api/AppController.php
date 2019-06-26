<?php
namespace App\Controller\Api;

use Cake\Controller\Controller;

use Crud\Controller\ControllerTrait;

class AppController extends Controller
{
    use ControllerTrait;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
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
