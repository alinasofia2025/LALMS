<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Faculties Controller
 *
 * @property \App\Model\Table\FacultiesTable $Faculties
 */
class FacultiesController extends AppController
{
    public function index()
    {
        $this->set('title', 'Faculty List');
        $search = trim((string)$this->request->getQuery('search'));
        $query = $this->Faculties->find();
        if ($search !== '') {
            $query = $query->where(function ($exp) use ($search) {
                return $exp->or(['Faculties.name LIKE' => '%' . $search . '%', 'Faculties.code LIKE' => '%' . $search . '%']);
            });
        }
        $this->paginate = ['limit' => 10, 'order' => ['Faculties.id' => 'DESC']];
        $faculties = $this->paginate($query);

        $this->set('total_records', $this->Faculties->find()->count());
        $this->set('active_records', $this->Faculties->find()->where(['Faculties.status' => 1])->count());
        $this->set('disabled_records', $this->Faculties->find()->where(['Faculties.status' => 0])->count());
        $this->set(compact('faculties', 'search'));
    }

    public function view($id = null)
    {
        $this->set('title', 'View Faculty');
        $faculty = $this->Faculties->get($id, contain: []);
        $this->set(compact('faculty'));
    }

    public function add()
    {
        $this->set('title', 'Add Faculty');
        $faculty = $this->Faculties->newEmptyEntity();
        if ($this->request->is('post')) {
            $faculty = $this->Faculties->patchEntity($faculty, $this->request->getData());
            if ($this->Faculties->save($faculty)) {
                $this->Flash->success(__('The faculty has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faculty could not be saved. Please, try again.'));
        }
        
        $this->set(compact('faculty'));
    }

    public function edit($id = null)
    {
        $this->set('title', 'Edit Faculty');
        $faculty = $this->Faculties->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $faculty = $this->Faculties->patchEntity($faculty, $this->request->getData());
            if ($this->Faculties->save($faculty)) {
                $this->Flash->success(__('The faculty has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faculty could not be updated. Please, try again.'));
        }
        
        $this->set(compact('faculty'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $faculty = $this->Faculties->get($id);
        if ($this->Faculties->delete($faculty)) {
            $this->Flash->success(__('The faculty has been deleted.'));
        } else {
            $this->Flash->error(__('The faculty could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}