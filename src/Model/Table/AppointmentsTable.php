<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Appointments Model
 *
 * @property \App\Model\Table\LecturersTable&\Cake\ORM\Association\BelongsTo $Lecturers
 * @property \App\Model\Table\FacultiesTable&\Cake\ORM\Association\BelongsTo $Faculties
 * @property \App\Model\Table\ProgramsTable&\Cake\ORM\Association\BelongsTo $Programs
 * @property \App\Model\Table\SubjectsTable&\Cake\ORM\Association\BelongsTo $Subjects
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AppointmentsTable extends Table
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

        $this->setTable('appointments');
        $this->setDisplayField('letter_ref_no');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lecturers', [
            'foreignKey' => 'lecturer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Faculties', [
            'foreignKey' => 'faculty_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Programs', [
            'foreignKey' => 'program_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Subjects', [
            'foreignKey' => 'subject_id',
            'joinType' => 'INNER',
        ]);

        $this->addBehavior('Search.Search');
        $this->searchManager()
            ->value('id')
            ->value('lecturer_id')
            ->value('faculty_id')
            ->value('program_id')
            ->value('subject_id')
            ->value('status')
            ->value('appointment_type')
            ->value('academic_session')
            ->value('semester')
            ->add('search', 'Search.Like', [
                'fieldMode' => 'OR',
                'multiValue' => true,
                'multiValueSeparator' => '|',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['letter_ref_no', 'appointment_title', 'remarks'],
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
            ->nonNegativeInteger('lecturer_id')
            ->notEmptyString('lecturer_id');

        $validator
            ->nonNegativeInteger('faculty_id')
            ->notEmptyString('faculty_id');

        $validator
            ->nonNegativeInteger('program_id')
            ->notEmptyString('program_id');

        $validator
            ->nonNegativeInteger('subject_id')
            ->notEmptyString('subject_id');

        $validator
            ->scalar('letter_ref_no')
            ->maxLength('letter_ref_no', 50)
            ->requirePresence('letter_ref_no', 'create')
            ->notEmptyString('letter_ref_no');

        $validator
            ->scalar('appointment_type')
            ->maxLength('appointment_type', 50)
            ->requirePresence('appointment_type', 'create')
            ->notEmptyString('appointment_type');

        $validator
            ->scalar('appointment_title')
            ->maxLength('appointment_title', 150)
            ->requirePresence('appointment_title', 'create')
            ->notEmptyString('appointment_title');

        $validator
            ->scalar('academic_session')
            ->maxLength('academic_session', 150)
            ->requirePresence('academic_session', 'create')
            ->notEmptyString('academic_session');

        $validator
            ->integer('semester')
            ->requirePresence('semester', 'create')
            ->notEmptyString('semester');

        $validator
            ->date('appointment_date')
            ->requirePresence('appointment_date', 'create')
            ->notEmptyDate('appointment_date');

        $validator
            ->date('effective_date')
            ->allowEmptyDate('effective_date');

        $validator
            ->date('appointment_start')
            ->allowEmptyDate('appointment_start');

        $validator
            ->date('appointment_end')
            ->allowEmptyDate('appointment_end');

        $validator
            ->scalar('remarks')
            ->allowEmptyString('remarks');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        $validator
            ->integer('created_by')
            ->notEmptyString('created_by');

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
        $rules->add($rules->existsIn(['lecturer_id'], 'Lecturers'), ['errorField' => 'lecturer_id']);
        $rules->add($rules->existsIn(['faculty_id'], 'Faculties'), ['errorField' => 'faculty_id']);
        $rules->add($rules->existsIn(['program_id'], 'Programs'), ['errorField' => 'program_id']);
        $rules->add($rules->existsIn(['subject_id'], 'Subjects'), ['errorField' => 'subject_id']);

        return $rules;
    }
}