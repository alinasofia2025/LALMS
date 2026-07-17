<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use PDOException;

/**
 * Lecturers Controller
 *
 * @property \App\Model\Table\LecturersTable $Lecturers
 */
class LecturersController extends AppController
{
    public function index()
    {
        $this->set('title', 'Lecturer List');
        $search = trim((string)$this->request->getQuery('search'));
        $query = $this->Lecturers->find()->contain(['Faculties', 'Programs']);
        if ($search !== '') {
            $query = $query->where(function ($exp) use ($search) {
                return $exp->or(['Lecturers.name LIKE' => '%' . $search . '%', 'Lecturers.email LIKE' => '%' . $search . '%', 'Faculties.name LIKE' => '%' . $search . '%', 'Programs.name LIKE' => '%' . $search . '%']);
            });
        }
        $this->paginate = ['limit' => 10, 'order' => ['Lecturers.id' => 'DESC']];
        $lecturers = $this->paginate($query);

        $this->set('total_records', $this->Lecturers->find()->count());
        $this->set('active_records', $this->Lecturers->find()->where(['Lecturers.status' => 1])->count());
        $this->set('disabled_records', $this->Lecturers->find()->where(['Lecturers.status' => 0])->count());
        $this->set(compact('lecturers', 'search'));
    }

    public function view($id = null)
    {
        $this->set('title', 'View Lecturer');
        // Removed 'Subjects' because the subjects table no longer has a lecturer_id column
        $lecturer = $this->Lecturers->get($id, contain: ['Faculties', 'Programs', 'Appointments']);
        $this->set(compact('lecturer'));
    }

    public function add()
    {
        $this->set('title', 'Add Lecturer');
        $lecturer = $this->Lecturers->newEmptyEntity();
        if ($this->request->is('post')) {
            $lecturer = $this->Lecturers->patchEntity($lecturer, $this->request->getData());
            if ($this->Lecturers->save($lecturer)) {
                $this->Flash->success(__('The lecturer has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lecturer could not be saved. Please, try again.'));
        }
        $faculties = $this->Lecturers->Faculties->find('list', limit: 200)->all();
        $programs = $this->Lecturers->Programs->find('list', limit: 200)->all();
        $this->set(compact('lecturer', 'faculties', 'programs'));
    }

    public function edit($id = null)
    {
        $this->set('title', 'Edit Lecturer');
        $lecturer = $this->Lecturers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lecturer = $this->Lecturers->patchEntity($lecturer, $this->request->getData());
            if ($this->Lecturers->save($lecturer)) {
                $this->Flash->success(__('The lecturer has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lecturer could not be updated. Please, try again.'));
        }
        $faculties = $this->Lecturers->Faculties->find('list', limit: 200)->all();
        $programs = $this->Lecturers->Programs->find('list', limit: 200)->all();
        $this->set(compact('lecturer', 'faculties', 'programs'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lecturer = $this->Lecturers->get($id);
        try {
            if ($this->Lecturers->delete($lecturer)) {
                $this->Flash->success(__('The lecturer has been deleted.'));
            } else {
                $this->Flash->error(__('The lecturer could not be deleted. Please, try again.'));
            }
        } catch (PDOException $e) {
            $this->Flash->error(__('This lecturer cannot be deleted because appointment records exist.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}