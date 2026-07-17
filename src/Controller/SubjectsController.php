<?php
declare(strict_types=1);

namespace App\Controller;

class SubjectsController extends AppController
{
    public function index()
    {
        $this->set('title', 'Subject List');
        $search = trim((string)$this->request->getQuery('search'));
        $query = $this->Subjects->find()->contain(['Faculties', 'Programs']);
        if ($search !== '') {
            $query = $query->where(function ($exp) use ($search) {
                return $exp->or([
                    'Subjects.name LIKE' => '%' . $search . '%',
                    'Subjects.code LIKE' => '%' . $search . '%',
                ]);
            });
        }
        $this->paginate = ['limit' => 10, 'order' => ['Subjects.id' => 'DESC']];
        $subjects = $this->paginate($query);

        $this->set('total_records', $this->Subjects->find()->count());
        $this->set('active_records', $this->Subjects->find()->where(['Subjects.status' => 1])->count());
        $this->set('disabled_records', $this->Subjects->find()->where(['Subjects.status' => 0])->count());
        $this->set(compact('subjects', 'search'));
    }

    public function view($id = null)
    {
        $this->set('title', 'View Subject');
        $subject = $this->Subjects->get($id, contain: ['Faculties', 'Programs', 'Appointments']);
        $this->set(compact('subject'));
    }

    public function add()
    {
        $this->set('title', 'Add Subject');
        $subject = $this->Subjects->newEmptyEntity();
        if ($this->request->is('post')) {
            $subject = $this->Subjects->patchEntity($subject, $this->request->getData());
            if ($this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subject could not be saved. Please, try again.'));
        }
        $faculties = $this->Subjects->Faculties->find('list')->all();
        $programs = $this->Subjects->Programs->find('list')->all();

        $this->set(compact('subject', 'faculties', 'programs'));
    }

    public function edit($id = null)
    {
        $this->set('title', 'Edit Subject');
        $subject = $this->Subjects->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subject = $this->Subjects->patchEntity($subject, $this->request->getData());
            if ($this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subject could not be updated. Please, try again.'));
        }
        $faculties = $this->Subjects->Faculties->find('list')->all();
        $programs = $this->Subjects->Programs->find('list')->all();

        $this->set(compact('subject', 'faculties', 'programs'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subject = $this->Subjects->get($id);

        $hasAppointments = $this->Subjects->Appointments->exists(['subject_id' => $id]);

        if ($hasAppointments) {
            $this->Flash->error(__('This subject cannot be deleted because it is assigned to one or more appointment letters.'));
        } else {
            if ($this->Subjects->delete($subject)) {
                $this->Flash->success(__('The subject has been deleted.'));
            } else {
                $this->Flash->error(__('The subject could not be deleted. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}