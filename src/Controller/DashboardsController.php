<?php

declare(strict_types=1);

namespace App\Controller;

class DashboardsController extends AppController
{
    public function index()
    {
        $this->set('title', 'Lecturer Appointment Letter Management System');

        $facultiesTable = $this->fetchTable('Faculties');
        $programsTable = $this->fetchTable('Programs');
        $lecturersTable = $this->fetchTable('Lecturers');
        $subjectsTable = $this->fetchTable('Subjects');
        $appointmentsTable = $this->fetchTable('Appointments');

        $faculties = $facultiesTable->find()->count();
        $programs = $programsTable->find()->count();
        $lecturers = $lecturersTable->find()->count();
        $subjects = $subjectsTable->find()->count();
        $appointments = $appointmentsTable->find()->count();

        $statusBreakdown = $appointmentsTable->find()
            ->select([
                'status' => 'Appointments.status',
                'count' => $appointmentsTable->find()->func()->count('*')
            ])
            ->group(['Appointments.status'])
            ->enableHydration(false)
            ->all()
            ->toArray();

        $statusLabelMap = [
            0 => 'Draft',
            1 => 'Approved',
            2 => 'Archived',
            3 => 'Rejected',
            4 => 'Pending',
        ];

        $statusChartLabels = [];
        $statusChartSeries = [];
        foreach ($statusBreakdown as $item) {
            $statusValue = (int)$item['status'];
            $statusChartLabels[] = $statusLabelMap[$statusValue] ?? 'Status ' . $statusValue;
            $statusChartSeries[] = (int)$item['count'];
        }

        $facultyBreakdown = $appointmentsTable->find()
            ->select([
                'faculty_name' => 'Faculties.name',
                'count' => $appointmentsTable->find()->func()->count('*')
            ])
            ->innerJoinWith('Faculties')
            ->group(['Faculties.id', 'Faculties.name'])
            ->orderAsc('Faculties.name')
            ->enableHydration(false)
            ->all()
            ->toArray();

        $facultyChartLabels = [];
        $facultyChartSeries = [];
        foreach ($facultyBreakdown as $item) {
            $facultyChartLabels[] = $item['faculty_name'] ?: 'Unknown Faculty';
            $facultyChartSeries[] = (int)$item['count'];
        }

        $latestAppointments = $appointmentsTable->find()
            ->contain([
                'Lecturers',
                'Faculties',
                'Subjects'
            ])
            ->orderBy([
                'Appointments.created' => 'DESC'
            ])
            ->limit(5)
            ->all();

        $statusChartData = [
            'labels' => $statusChartLabels,
            'series' => $statusChartSeries,
        ];

        $facultyChartData = [
            'labels' => $facultyChartLabels,
            'series' => $facultyChartSeries,
        ];

        $this->set(compact(
            'faculties',
            'programs',
            'lecturers',
            'subjects',
            'appointments',
            'latestAppointments',
            'statusChartData',
            'facultyChartData'
        ));
    }
}