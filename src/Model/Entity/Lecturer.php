<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lecturer Entity
 */
class Lecturer extends Entity
{
    /**
     * Fields that can be mass assigned using patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        // Lecturer Information
        'staff_no' => true,
        'name' => true,
        'email' => true,
        'phone' => true,
        'password' => true,

        // Foreign Keys
        'faculty_id' => true,
        'program_id' => true,

        // Status
        'status' => true,

        // Timestamps
        'created' => true,
        'modified' => true,

        // Associations
        'faculty' => true,
        'program' => true,
        'appointments' => true,
    ];
}