<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LecturersTable extends Table
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

        $this->setTable('lecturers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Faculties', [
            'foreignKey' => 'faculty_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Programs', [
            'foreignKey' => 'program_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('Subjects', [
            'foreignKey' => 'lecturer_id',
        ]);
        $this->hasMany('Appointments', [
            'foreignKey' => 'lecturer_id',
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
            ->integer('faculty_id')
            ->notEmptyString('faculty_id');

        $validator
            ->integer('program_id')
            ->notEmptyString('program_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        return $validator;
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
        $rules->add($rules->existsIn(['faculty_id'], 'Faculties'), ['errorField' => 'faculty_id']);
        $rules->add($rules->existsIn(['program_id'], 'Programs'), ['errorField' => 'program_id']);

        return $rules;
    }
}