<?php
namespace App\Controller\Api;

use Crud\Controller\ControllerTrait;
use Cake\Event\Event;

use App\Controller\AppController as Controller;

/**
 * API parent controller
 *
 */
class AppController extends Controller
{
    use ControllerTrait;

    // Default custom actions.
    protected $customActions = [];

    /**
     * Initialize method. Loads the Crud component to generate the API.
     *
     * @return void
     */
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

    /**
     * Calls the registerCustomActions function. method that registers custom actions for children components..
     *
     * @param \Cake\Event\Event $event BeforeFilter Event data.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->registerCustomActions();
    }

    /**
     * Registers custom actions for children components..
     *
     * @return void
     */
    protected function registerCustomActions()
    {
        if ($this->customActions && is_array($this->customActions)) {
            foreach ($this->customActions as $action => $config) {
                $this->Crud->mapAction($action, $config);
            }
        }
    }
}
