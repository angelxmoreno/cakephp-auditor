<?php

namespace Auditor\Model\Behavior;

use Auditor\Model\Table\AuditsTable;
use Cake\ORM\Query;

/**
 * Class AuditorBehavior
 *
 * @package Auditor\Model\Behavior
 */
class AuditorBehavior extends BaseBehavior
{
    /**
     *
     * @var array
     */
    protected $_defaultConfig
        = [
            'attach'            => true,
            'skip_fields'       => [],
            'association_names' => [
                'AuditsCreated' => 'create',
                'AuditsDeleted' => 'delete',
                'AuditsSaved'   => 'save',
            ],
        ];

    /**
     *
     * @param array $config
     */
    public function initialize(array $config = [])
    {
        $users_table = $this->getTable();

        $users_table->hasMany('Audits', [
            'className' => AuditsTable::class,
        ])->setSort('Audits.created DESC');

        $map = $this->getConfig('association_names');
        foreach ($map as $alias => $action) {
            $users_table->hasMany($alias, [
                'className' => AuditsTable::class,
            ])->setConditions([$alias . '.action' => $action]);
        }
    }

    /**
     * @param array $paginate
     *
     * @return array
     */
    public function auditorPaginate(array $paginate = [])
    {
        $map = $this->getConfig('association_names');
        foreach ($map as $alias => $action) {
            $aggregate_key = $alias . '.user_id';

            $paginate['contain'][$alias] = function (Query $q) use ($aggregate_key) {
                $q->select([
                    $aggregate_key,
                    'total' => $q->func()->count($aggregate_key),
                ])
                  ->group([$aggregate_key]);

                return $q;
            };
        }

        return $paginate;
    }
}
