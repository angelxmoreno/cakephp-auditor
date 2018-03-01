<?php

namespace Auditor\Model\Table\Traits;

use App\Model\Table\AppTable;
use Cake\ORM\ResultSet;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Trait EntityAttachTrait
 *
 * Attaches audited model display names to the AuditResultSet
 *
 * @package Auditor\Model\Table\Traits
 */
trait EntityAttachTrait
{
    /**
     * @var array
     */
    protected $entity_class_map = [];
    
    /**
     * @param ResultSet $audits
     *
     * @return ResultSet
     */
    public function attachForeignEntities(ResultSet $audits)
    {
        $entity_table_map = $this->createEntityTableMap($audits);
        $lookup           = $this->createEntityLookUpList($entity_table_map);
        foreach ($audits as $key => $result) {
            $result['attached'] = isset($lookup[$result->model_name][$result->id])
                ? $lookup[$result->model_name][$result->id]
                : $result->id;
        }

        return $audits;
    }

    /**
     * @param array $entity_table_map
     *
     * @return array
     */
    protected function createEntityLookUpList(array $entity_table_map)
    {
        $lookup = [];

        foreach ($entity_table_map as $entity_class => $meta) {
            /** @var AppTable $table */
            $table   = $meta['table'];
            $ids     = $meta['ids'];
            $sub_set = $table
                ->find('list')
                ->where([
                    'id IN' => $ids,
                ])
                ->toArray();

            $lookup[$entity_class] = $sub_set;
        }

        return $lookup;
    }

    /**
     * @param ResultSet $audits
     *
     * @return array
     */
    protected function createEntityTableMap(ResultSet $audits)
    {
        $entity_map = [];

        foreach ($audits as $audit) {
            $entity_class_name = $audit->model_name;
            $entity_id         = $audit->model_uid;

            if (!array_key_exists($entity_class_name, $entity_map)) {
                $entity_map[$entity_class_name] = [
                    'table' => $this->getTableFromEntity($entity_class_name),
                    'ids'   => [],
                ];
            }

            if (!in_array($entity_id, $entity_map[$entity_class_name]['ids'])) {
                $entity_map[$entity_class_name]['ids'][] = $entity_id;
            }
        }

        return $entity_map;
    }

    /**
     * @param $entity_name
     *
     * @return AppTable
     */
    protected function getTableFromEntity($entity_name)
    {
        if (!array_key_exists($entity_name, $this->entity_class_map)) {
            $parts                                = explode('\\', $entity_name);
            $top_name_space                       = reset($parts);
            $plugin                               = ($top_name_space === 'App') ? null : $top_name_space;
            $short_name                           = end($parts);
            $table_name                           = Inflector::pluralize($short_name);
            $this->entity_class_map[$entity_name] = TableRegistry::get($table_name, [
                'plugin' => $plugin,
            ]);
        }

        return $this->entity_class_map[$entity_name];
    }
}
