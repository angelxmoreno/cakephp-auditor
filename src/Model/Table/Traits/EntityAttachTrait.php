<?php

namespace Auditor\Model\Table\Traits;

use App\Model\Table\AppTable;
use Cake\ORM\ResultSet;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Trait EntityAttachTrait
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
     * @param ResultSet $results
     *
     * @return ResultSet
     */
    public function attachForeignEntities(ResultSet $results)
    {
        $map    = $this->createEntityTableMap($results);
        $lookup = $this->createEntityLookUpArray($map);
        foreach ($results as $key => $result) {
            $result['attached'] = isset($lookup[$result->model_name][$result->id])
                ? $lookup[$result->model_name][$result->id]
                : $result->id;
        }

        return $results;
    }

    /**
     * @param array $map
     *
     * @return array
     */
    public function createEntityLookUpArray(array $map)
    {
        $lookup = [];

        foreach ($map as $entity_class => $meta) {
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
     * @param ResultSet $results
     *
     * @return array
     */
    public function createEntityTableMap(ResultSet $results)
    {
        $entity_map = [];

        foreach ($results as $result) {
            $entity_class_name = $result->model_name;
            $entity_id         = $result->model_uid;

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
    public function getTableFromEntity($entity_name)
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
