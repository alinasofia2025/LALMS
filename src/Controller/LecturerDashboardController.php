<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class LecturerDashboardController extends AppController
{
    public function index()
    {
        $this->set('title', 'Lecturer Dashboard');

        // Get the logged-in user
        $user = $this->Authentication->getIdentity();
        $userId = $user->get('id');

        // Find the lecturer associated with this user via user_id
        $lecturersTable = TableRegistry::getTableLocator()->get('Lecturers');
        $lecturer = $lecturersTable->find()
            ->where(['user_id' => $userId])
            ->contain(['Faculties', 'Programs'])
            ->first();

        // If no lecturer record exists, redirect to profile with error
        if (!$lecturer) {
            $this->Flash->error('No lecturer record found for your account. Please contact administrator.');
            return $this->redirect(['controller' => 'Users', 'action' => 'profile', $user->get('slug')]);
        }

        // Now we have a valid lecturer, fetch appointment stats
        $appointmentsTable = TableRegistry::getTableLocator()->get('Appointments');
        $totalAppointments = $appointmentsTable->find()
            ->where(['lecturer_id' => $lecturer->id])
            ->count();

        $pendingAppointments = $appointmentsTable->find()
            ->where(['lecturer_id' => $lecturer->id, 'status' => 0]) // assuming 0 = pending/draft
            ->count();

        $approvedAppointments = $appointmentsTable->find()
            ->where(['lecturer_id' => $lecturer->id, 'status' => 1])
            ->count();

        $rejectedAppointments = $appointmentsTable->find()
            ->where(['lecturer_id' => $lecturer->id, 'status' => 2]) // assuming 2 = rejected/archived
            ->count();

        // Get recent appointments (latest 5)
        $recentAppointments = $appointmentsTable->find()
            ->where(['lecturer_id' => $lecturer->id])
            ->contain(['Faculties', 'Programs', 'Subjects'])
            ->orderBy(['Appointments.created' => 'DESC'])
            ->limit(5)
            ->all();

        // Upcoming teaching schedule (future appointments)
        $upcomingAppointments = $appointmentsTable->find()
            ->where(['lecturer_id' => $lecturer->id])
            ->where(['appointment_date >=' => new \DateTimeImmutable('today')])
            ->contain(['Programs', 'Subjects'])
            ->orderAsc('appointment_date')
            ->limit(4)
            ->all();

        $subjectsTable = TableRegistry::getTableLocator()->get('Subjects');
        $appointmentsTable = TableRegistry::getTableLocator()->get('Appointments');

        // The subjects table does not have a `lecturer_id` column.
        // Lecturers are linked to subjects via the `appointments` table
        // (appointments.subject_id → subjects.id, appointments.lecturer_id → lecturers.id).
        // Use a matching() join through Appointments to get subjects assigned to this lecturer.
        $assignedSubjectsQuery = $subjectsTable->find()
            ->contain(['Programs', 'Faculties'])
            ->matching('Appointments', function ($q) use ($lecturer) {
                return $q->where(['Appointments.lecturer_id' => $lecturer->id]);
            })
            ->distinct(['Subjects.id'])
            ->orderAsc('Subjects.name');

        $assignedSubjectCount = (int)$assignedSubjectsQuery->count();
        $assignedSubjects = $assignedSubjectsQuery->all();

        $activityTimeline = [];
        foreach ($recentAppointments as $appointment) {
            $statusLabels = [0 => 'Draft', 1 => 'Approved', 2 => 'Rejected'];
            $activityTimeline[] = [
                'title' => $appointment->appointment_title,
                'type' => $statusLabels[$appointment->status] ?? 'Updated',
                'date' => $appointment->created,
                'meta' => $appointment->academic_session,
                'link' => ['controller' => 'Appointments', 'action' => 'view', $appointment->id, 'prefix' => 'Lecturer'],
            ];
        }

        $this->set(compact(
            'lecturer',
            'totalAppointments',
            'pendingAppointments',
            'approvedAppointments',
            'rejectedAppointments',
            'recentAppointments',
            'upcomingAppointments',
            'assignedSubjectCount',
            'assignedSubjects',
            'activityTimeline'
        ));

        // Use the lecturer-specific layout
        $this->viewBuilder()->setLayout('lecturer');
    }
}