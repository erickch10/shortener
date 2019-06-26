<?php
namespace App\Controller\Crud\Action;

use Crud\Action\BaseAction;
use Crud\Traits\FindMethodTrait;
use Crud\Traits\SerializeTrait;
use Crud\Traits\ViewTrait;
use Crud\Traits\ViewVarTrait;

class TopVisited extends BaseAction
{
    use FindMethodTrait;
    use SerializeTrait;
    use ViewTrait;
    use ViewVarTrait;

    /**
     * Default settings
     *
     * @var array
     */
    protected $_defaultConfig = [
        'scope' => 'table',
        'findMethod' => 'all',
    ];

    /**
    * Generic handler for all HTTP verbs
    *
    * @return void
    */
    protected function _handle()
    {
        $query = $this->buildQuery();
        $subject = $this->_subject(['success' => true, 'query' => $query]);

        $items = $subject->query->toArray();
        $subject->set(['entities' => $items]);
        $this->_trigger('beforeRender', $subject);
    }

    protected function buildQuery()
    {
        list($finder, $options) = $this->_extractFinder();
        $query = $this->_table()->find($finder, $options);
        $limit = $this->_controller()->request->getQuery('limit', 100);
        $query->order(['visits' => 'DESC']);
        $query->limit($limit);
        return $query;
    }
}
