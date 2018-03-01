<?php

namespace Auditor\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Routing\Router;

class AuditBehavior extends BaseBehavior
{
    const NAME = 'Auditor.Audit';
    const DELETE = 'Delete';
    const CREATE = 'Create';

    /**
     *
     * @var array
     */
    protected $_defaultConfig
        = [
            'attach'      => true,
            'reverse'     => false,
            'skip_fields' => [],
        ];

    /**
     *
     * @param array $config
     */
    public function initialize(array $config = [])
    {
        $audit_table   = $this->getAuditTable();
        $linking_table = $this->getTable();
        if ($this->getConfig('attach')) {
            $linking_table->hasMany(self::AUDIT_MODEL, [
                'foreignKey' => 'model_uid',
                'conditions' => [
                    'model_name' => $linking_table->getEntityClass(),
                ],
            ]);
        }

        if ($this->getConfig('reverse')) {
            $audit_table
                ->belongsTo($linking_table->getAlias())
                ->setForeignKey('model_uid')
                ->setConditions([
                    $audit_table->getAlias() . '.model_name' => $linking_table->getEntityClass(),
                ]);
        }
    }

    /**
     *
     * @param Table $table
     * @param array $config
     */
    public static function makeAuditable(Table $table, array $config = [])
    {
        if ($table->getRegistryAlias() <> self::AUDIT_MODEL) {
            $table->addBehavior(self::NAME, $config);
        }
    }

    /**
     *
     * @param Event           $event
     * @param EntityInterface $entity
     * @param ArrayObject     $options
     */
    public function afterDelete(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->audit($event, $entity);
    }

    /**
     *
     * @param Event           $event
     * @param EntityInterface $entity
     * @param ArrayObject     $options
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->audit($event, $entity);
    }

    /**
     *
     * @param Event           $event
     * @param EntityInterface $entity
     */
    protected function audit(Event $event, EntityInterface $entity)
    {
        $data        = $this->buildLogData($entity, $event);
        $audit       = $this->getAuditTable()->newEntity($data);
        $has_changed = count($audit->previous) > 0 && count($audit->current) > 0;
        $is_delete   = $audit->action === self::DELETE;
        $is_create   = $audit->action === self::CREATE;

        if ($has_changed || $is_delete || $is_create) {
            $saved = $this->getAuditTable()->save($audit);
        }
    }

    /**
     *
     * @param EntityInterface $entity
     * @param Event           $event
     *
     * @return array
     */
    protected function buildLogData(EntityInterface $entity, Event $event)
    {
        $event_name = str_replace('Model.after', '', $event->name);
        $action     = $entity->isNew() ? self::CREATE : $event_name;

        $previous = $event_name === self::DELETE ? $entity->toArray() : $this->getPrevious($entity);

        $data = [
            'action'     => $action,
            'user_id'    => $this->getUserId(),
            'model_name' => get_class($entity),
            'model_uid'  => $entity->get($this->getAuditTable()->getPrimaryKey()),
            'previous'   => $previous,
            'current'    => $this->getCurrent($entity),
        ];

        if ($data['action'] === self::CREATE && $data['previous'] === $data['current']) {
            $data['previous'] = [];
        }

        return $data;
    }

    /**
     *
     * @param EntityInterface $entity
     *
     * @return array
     */
    protected function getPrevious(EntityInterface $entity)
    {
        $changed_fields = $entity->getDirty();
        $fields         = [];
        foreach ($changed_fields as $changed_field) {
            if (!in_array($changed_field, $this->getConfig('skip_fields'))) {
                $fields[$changed_field] = $entity->getOriginal($changed_field);
            }
        }

        return $fields;
    }

    /**
     *
     * @param EntityInterface $entity
     *
     * @return array
     */
    protected function getCurrent(EntityInterface $entity)
    {
        $changed_fields = $entity->getDirty();
        $fields         = [];
        foreach ($changed_fields as $changed_field) {
            if (!in_array($changed_field, $this->getConfig('skip_fields'))) {
                $fields[$changed_field] = $entity->get($changed_field);
            }
        }

        return $fields;
    }

    /**
     * @return null|string
     */
    protected function getUserId()
    {
        return Router::getRequest() ? Router::getRequest()->session()->read('Auth.User.id') : null;
    }

}
