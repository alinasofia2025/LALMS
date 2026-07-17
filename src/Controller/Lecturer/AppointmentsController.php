<?php
declare(strict_types=1);

namespace App\Controller\Lecturer;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

class AppointmentsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('lecturer');
    }

    public function index()
    {
        $this->set('title', 'My Appointment Letters');

        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
        }

        $lecturersTable = $this->fetchTable('Lecturers');
        $lecturer = $lecturersTable->find()
            ->where(['Lecturers.user_id' => $identity->get('id')])
            ->first();

        if (!$lecturer) {
            $this->Flash->error('No lecturer record found for your account.');
            return $this->redirect(['controller' => 'Users', 'action' => 'profile', 'prefix' => false, $identity->get('slug')]);
        }

        $appointmentsTable = $this->fetchTable('Appointments');
        $appointments = $appointmentsTable->find()
            ->where(['Appointments.lecturer_id' => $lecturer->id])
            ->contain(['Lecturers', 'Faculties', 'Programs', 'Subjects'])
            ->orderBy(['Appointments.created' => 'DESC'])
            ->all();

        $this->set(compact('appointments', 'lecturer'));
    }

    public function view($id = null)
    {
        $this->set('title', 'Appointment Letter Details');

        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
        }

        $lecturersTable = $this->fetchTable('Lecturers');
        $lecturer = $lecturersTable->find()
            ->where(['Lecturers.user_id' => $identity->get('id')])
            ->first();

        if (!$lecturer) {
            $this->Flash->error('No lecturer record found for your account.');
            return $this->redirect(['controller' => 'Users', 'action' => 'profile', 'prefix' => false, $identity->get('slug')]);
        }

        $appointmentsTable = $this->fetchTable('Appointments');
        $appointment = $appointmentsTable->find()
            ->where(['Appointments.id' => $id, 'Appointments.lecturer_id' => $lecturer->id])
            ->contain(['Lecturers', 'Faculties', 'Programs', 'Subjects'])
            ->first();

        if (!$appointment) {
            throw new NotFoundException(__('Appointment not found.'));
        }

        $this->set(compact('appointment', 'lecturer'));
    }
}
