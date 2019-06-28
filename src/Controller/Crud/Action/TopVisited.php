<?php
namespace App\Controller\Crud\Action;

use Crud\Action\BaseAction;
use Crud\Traits\FindMethodTrait;
use Crud\Traits\SerializeTrait;
use Crud\Traits\ViewTrait;
use Crud\Traits\ViewVarTrait;

/**
 * Top visited action
 *
 */
class TopVisited extends BaseAction
{
    use FindMethodTrait;
    use SerializeTrait;
    use ViewTrait;
    use ViewVarTrait;

    /**
     * Top visited action settings
     *
     * @var array
     */
    protected $_defaultConfig = [
        'scope' => 'table',
        'findMethod' => 'all',
    ];

    /**
     * Handler for the top visited action.
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

    /**
     * Build query object to retrieve the URLs from the most visited to the least visited.
     *     The records can be modifed through the query string, Default value is 100.
     *
     * @return \Cake\ORM\Query The query builder
     */
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
