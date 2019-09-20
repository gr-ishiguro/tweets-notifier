<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotifyInformation Model
 *
 * @method \App\Model\Entity\NotifyInformation get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotifyInformation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotifyInformation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotifyInformation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotifyInformation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotifyInformation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotifyInformation findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NotifyInformationTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('notify_information');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null,'create');

        $validator
            ->allowEmptyString('search_key');

        $validator
            ->allowEmptyString('callback');

        $validator
            ->allowEmptyString('component');

        $validator
            ->allowEmptyString('last_acquired');

        return $validator;
    }
}
