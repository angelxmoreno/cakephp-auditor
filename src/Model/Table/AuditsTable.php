<?php

namespace Auditor\Model\Table;

use App\Model\Table\AppTable;
use Auditor\Model\Table\Traits\EntityAttachTrait;
use Cake\Database\Schema\TableSchema;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Audits Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Auditor\Model\Entity\Audit get($primaryKey, $options = [])
 * @method \Auditor\Model\Entity\Audit newEntity($data = null, array $options = [])
 * @method \Auditor\Model\Entity\Audit[] newEntities(array $data, array $options = [])
 * @method \Auditor\Model\Entity\Audit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Auditor\Model\Entity\Audit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Auditor\Model\Entity\Audit[] patchEntities($entities, array $data, array $options = [])
 * @method \Auditor\Model\Entity\Audit findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuditsTable extends AppTable
{
    use EntityAttachTrait;

    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->columnType('current', 'json');
        $schema->columnType('previous', 'json');

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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     *
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
