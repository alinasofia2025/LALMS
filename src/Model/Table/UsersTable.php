<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\UserGroupsTable&\Cake\ORM\Association\BelongsTo $UserGroups
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UserGroups', [
            'foreignKey' => 'user_group_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_group_id')
            ->notEmptyString('user_group_id');

        $validator
            ->scalar('fullname')
            ->maxLength('fullname', 255)
            ->requirePresence('fullname', 'create')
            ->notEmptyString('fullname', 'Full name is required');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password', 'Password is required');

        $validator
            ->scalar('cpassword')
            ->maxLength('cpassword', 255)
            ->requirePresence('cpassword', 'create')
            ->notEmptyString('cpassword', 'Confirm password is required')
            ->add('cpassword', [
                'compare' => [
                    'rule' => ['compareWith', 'password'],
                    'message' => 'Password does not match'
                ]
            ]);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Email is required')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'This email is already registered']);

        $validator
            ->allowEmptyFile('avatar')
            ->add('avatar', [
                'validExtension' => [
                    'rule' => ['extension', ['jpg', 'jpeg', 'png', 'gif']],
                    'message' => __('Only image files (jpg, jpeg, png, gif) are allowed.')
                ]
            ]);

        return $validator;
    }

    /**
     * Check for same password custom validator rule.
     */
    public function checkForSamePassword($value, $context)
    {
        if (!empty($value) && $value != $context['data']['password']) {
            return false;
        }
        return true;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn('user_group_id', 'UserGroups'), ['errorField' => 'user_group_id']);

        return $rules;
    }
}