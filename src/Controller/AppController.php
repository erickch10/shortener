<?php
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * App parent controller
 *
 */
class AppController extends Controller
{
    /**
     * Initialize method. Loads the RequestHandler to manage json and xml responses
     *     in case their wanted.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
}
