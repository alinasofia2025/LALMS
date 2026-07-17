<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Programs Controller
 *
 * @property \App\Model\Table\ProgramsTable $Programs
 */
class ProgramsController extends AppController
{
    public function index()
    {
        $this->set('title', 'Program List');
        $search = trim((string)$this->request->getQuery('search'));
        $query = $this->Programs->find();
        if ($search !== '') {
            $query = $query->where(function ($exp) use ($search) {
                return $exp->or(['Programs.name LIKE' => '%' . $search . '%', 'Programs.code LIKE' => '%' . $search . '%']);
            });
        }
        $this->paginate = ['limit' => 10, 'order' => ['Programs.id' => 'DESC']];
        $programs = $this->paginate($query);

        $this->set('total_records', $this->Programs->find()->count());
        $this->set('active_records', $this->Programs->find()->where(['Programs.status' => 1])->count());
        $this->set('disabled_records', $this->Programs->find()->where(['Programs.status' => 0])->count());
        $this->set(compact('programs', 'search'));
    }

    public function view($id = null)
    {
        $this->set('title', 'View Program');
        $program = $this->Programs->get($id, contain: []);
        $this->set(compact('program'));
    }

    public function add()
    {
        $this->set('title', 'Add Program');
        $program = $this->Programs->newEmptyEntity();
        if ($this->request->is('post')) {
            $program = $this->Programs->patchEntity($program, $this->request->getData());
            if ($this->Programs->save($program)) {
                $this->Flash->success(__('The program has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The program could not be saved. Please, try again.'));
        }
        
        $this->set(compact('program'));
    }

    public function edit($id = null)
    {
        $this->set('title', 'Edit Program');
        $program = $this->Programs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $program = $this->Programs->patchEntity($program, $this->request->getData());
            if ($this->Programs->save($program)) {
                $this->Flash->success(__('The program has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The program could not be updated. Please, try again.'));
        }
        
        $this->set(compact('program'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $program = $this->Programs->get($id);
        if ($this->Programs->delete($program)) {
            $this->Flash->success(__('The program has been deleted.'));
        } else {
            $this->Flash->error(__('The program could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}