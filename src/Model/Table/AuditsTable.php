<?php

namespace Auditor\Model\Table;

use App\Model\Table\AppTable;
use Auditor\Model\Table\Traits\EntityAttachTrait;
use Cake\Database\Schema\TableSchema;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Auditor\Model\Entity\Audit;
use Cake\Datasource\EntityInterface;
use Cake\ORM;

/**
 * Audits Model
 *
 * @property \App\Model\Table\UsersTable|ORM\Association\BelongsTo $Users
 *
 * @method Audit get($primaryKey, $options = [])
 * @method Audit newEntity($data = null, array $options = [])
 * @method Audit[] newEntities(array $data, array $options = [])
 * @method Audit|bool save(EntityInterface $entity, $options = [])
 * @method Audit patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Audit[] patchEntities($entities, array $data, array $options = [])
 * @method Audit findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin ORM\Behavior\TimestampBehavior
 */
class AuditsTable extends AppTable
{
    use EntityAttachTrait;

    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->setColumnType('current', 'json');
        $schema->setColumnType('previous', 'json');

        return $schema;
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('audits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className'  => 'Auditor.Users',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('model_name')
            ->allowEmpty('model_name');

        $validator
            ->integer('model_uid')
            ->allowEmpty('model_uid');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param ORM\RulesChecker $rules The rules object to be modified.
     *
     * @return ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
