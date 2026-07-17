<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Subject extends Entity
{
    protected array $_accessible = [
        'faculty_id' => true,
        'program_id' => true,
        'lecturer_id' => true,
        'code' => true,
        'name' => true,
        'credit_hours' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'faculty' => true,
        'program' => true,
        'lecturer' => true,
        'appointments' => true,
    ];
}
