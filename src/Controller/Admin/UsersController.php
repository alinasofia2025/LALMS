<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\EventInterface;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('Search.Search', [
			'actions' => ['index'],
		]);
	}

	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);

		$this->Authentication->allowUnauthenticated(['registration']);
	}

	public function index()
	{
		$this->set('title', 'User Management');
		$this->paginate = ['maxLimit' => 10];
		$query = $this->Users->find()->contain(['UserGroups']);

		$search = trim((string)$this->request->getQuery('search'));
		if ($search !== '') {
			$query->where([
				'OR' => [
					'Users.fullname LIKE' => '%' . $search . '%',
					'Users.email LIKE' => '%' . $search . '%',
					'Users.slug LIKE' => '%' . $search . '%',
				],
			]);
		}

		$users = $this->paginate($query);
		$this->set(compact('users', 'search'));
	}



	public function registration()
	{
		$this->set('title', 'User Registration');
		$user = $this->Users->newEmptyEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'register']);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$userGroups = $this->Users->UserGroups->find('list', ['limit' => 200])->all();
		$this->set(compact('user', 'userGroups'));
	}

	public function view($slug = null)
	{
		return $this->redirect(['action' => 'profile', $slug]);
	}

	public function profile($slug = null)
	{
		$this->set('title', 'User Profile');
		$user = $this->Users
			->findBySlug($slug)
			->contain(['UserGroups'])
			->firstOrFail();
		$this->set(compact('user'));
	}

	public function update($slug = null)
	{
		$this->set('title', 'Edit User');
		$user = $this->Users
			->findBySlug($slug)
			->contain(['UserGroups'])
			->firstOrFail();

		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('User updated successfully.'));
				return $this->redirect(['action' => 'profile', $user->slug]);
			}
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$this->set(compact('user'));
	}

	public function changePassword($slug = null)
	{
		$this->set('title', 'Change Password');
		$user = $this->Users
			->findBySlug($slug)
			->contain(['UserGroups'])
			->firstOrFail();

		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'password']);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Password has been updated.'));
				return $this->redirect(['action' => 'profile', $user->slug]);
			}
			$this->Flash->error(__('Your password could not be updated. Please, try again.'));
		}
		$this->set(compact('user'));
	}

	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->success(__('User deleted successfully.'));
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		return $this->redirect(['action' => 'index']);
	}

	public function activate($slug = null)
	{
		$user = $this->Users
			->findBySlug($slug)
			->contain(['UserGroups'])
			->firstOrFail();

		if ($this->request->is(['patch', 'post', 'put'])) {
			$user->status = 1;
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Account has been activated'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Cannot activate. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}

	public function disable($slug = null)
	{
		$user = $this->Users
			->findBySlug($slug)
			->contain(['UserGroups'])
			->firstOrFail();

		if ($this->request->is(['patch', 'post', 'put'])) {
			$user->status = 0;
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Account has been disabled'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Cannot disable. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}


	public function csv()
	{
		$data = $this->Users->find();
		$header = ['ID', 'Group ID', 'Fullname', 'Email', 'Created', 'Modified'];
		$extract = ['id', 'user_group_id', 'fullname', 'email', 'created', 'modified'];

		$this->set(compact('data'));
		$this->viewBuilder()
			->setClassName('CsvView.Csv')
			->setOptions([
				'serialize' => 'data',
				'header' => $header,
				'extract' => $extract,
			]);
	}

	public function json()
	{
		$this->viewBuilder()->enableAutoLayout(false);
		$users = $this->paginate('Users');
		$this->set(compact('users'));
	}
}
