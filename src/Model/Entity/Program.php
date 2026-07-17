<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Program extends Entity
{
    protected array $_accessible = [
        'name' => true,
        'code' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'lecturers' => true,
    ];
}
