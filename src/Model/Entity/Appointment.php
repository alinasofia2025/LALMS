<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Appointment Entity
 *
 * @property int $id
 * @property int $lecturer_id
 * @property int $faculty_id
 * @property int $program_id
 * @property int $subject_id
 * @property string $letter_ref_no
 * @property string $appointment_type
 * @property string $appointment_title
 * @property string $academic_session
 * @property int $semester
 * @property \Cake\I18n\Date $appointment_date
 * @property \Cake\I18n\Date $appointment_start
 * @property \Cake\I18n\Date $appointment_end
 * @property string|null $remarks
 * @property int $status
 * @property int|null $created_by
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Lecturer $lecturer
 * @property \App\Model\Entity\Faculty $faculty
 * @property \App\Model\Entity\Program $program
 * @property \App\Model\Entity\Subject $subject
 */
class Appointment extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'lecturer_id' => true,
        'faculty_id' => true,
        'program_id' => true,
        'subject_id' => true,
        'letter_ref_no' => true,
        'appointment_type' => true,
        'appointment_title' => true,
        'academic_session' => true,
        'semester' => true,
        'appointment_date' => true,
        'effective_date' => true,
        'appointment_start' => true,
        'appointment_end' => true,
        'remarks' => true,
        'status' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
        'lecturer' => true,
        'faculty' => true,
        'program' => true,
        'subject' => true,
    ];
}