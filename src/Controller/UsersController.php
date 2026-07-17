<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Laminas\Diactoros\UploadedFile;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // $this->loadComponent('Search.Search', ['actions' => ['index']]);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'registration']);
    }

    /**
     * Handle avatar upload from the request data.
     * - If a valid uploaded file is present, move it and return the filename.
     * - If no file or an invalid file, the avatar key is removed from the data array.
     * - If an existing avatar filename is provided, it is kept when no new file is uploaded.
     *
     * @param array $data The request data array (by reference, we modify it).
     * @param string|null $existingAvatar The existing avatar filename (if any).
     * @param string|null $uploadFolderName The folder name (e.g., user slug) to store the file.
     * @return array The modified data array.
     */
    protected function handleAvatarUpload(array $data, ?string $existingAvatar = null, ?string $uploadFolderName = null): array
    {
        // Check for a file upload field in the data
        $uploadField = null;
        foreach (['avatar', 'profile_picture', 'profile_image', 'image'] as $fieldName) {
            if (isset($data[$fieldName]) && $data[$fieldName] instanceof UploadedFileInterface) {
                $uploadField = $fieldName;
                break;
            }
        }

        // If no uploaded file field found, keep existing avatar or remove the field
        if ($uploadField === null) {
            if ($existingAvatar !== null) {
                $data['avatar'] = $existingAvatar;
            } else {
                unset($data['avatar']);
            }
            return $data;
        }

        /** @var UploadedFileInterface $uploadedFile */
        $uploadedFile = $data[$uploadField];

        // Check for upload errors or empty file
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK || $uploadedFile->getSize() <= 0) {
            // If there was an error or empty file, keep existing or remove
            if ($existingAvatar !== null) {
                $data['avatar'] = $existingAvatar;
            } else {
                unset($data['avatar']);
            }
            // Remove the file field from data to avoid serialization issues
            unset($data[$uploadField]);
            return $data;
        }

        // Generate a safe filename and move the file
        $extension = pathinfo($uploadedFile->getClientFilename() ?? 'avatar', PATHINFO_EXTENSION);
        $extension = $extension !== '' ? strtolower($extension) : 'jpg';
        $fileName = Text::uuid() . '.' . $extension;

        $folderName = $uploadFolderName ?: Text::uuid();
        $targetDir = WWW_ROOT . 'files' . DIRECTORY_SEPARATOR . 'Users' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . $folderName;

        if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
            throw new \RuntimeException(sprintf('Unable to create upload directory: %s', $targetDir));
        }

        $uploadedFile->moveTo($targetDir . DIRECTORY_SEPARATOR . $fileName);

        // Replace the avatar field with the new filename and remove the file field
        $data['avatar'] = $fileName;
        unset($data[$uploadField]);

        return $data;
    }

    public function login()
    {
        $this->set('title', 'Sign-in');
        $this->set('metaTitle', 'Re-CRUD Login');
        $this->set('metaKeywords', 'recrud, re-crud, login, auth');
        $this->set('metaSubject', 'Learning Coding');
        $this->set('metaCopyright', 'Re-CRUD');
        $this->set('metaDescription', 'This is a login page only');

        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $identity = $this->Authentication->getIdentity();
            $userGroupId = $identity->get('user_group_id');

            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Dashboards',
                'action' => 'index',
            ]);

            $this->updateLoginFields();
            return $this->redirect($redirect);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid username or password');
        }
    }

    protected function updateLoginFields()
    {
        $user = $this->Authentication->getIdentity();
        $this->request->getSession()->write('User.last_login', date('Y-m-d H:i:s'));
        $this->request->getSession()->write('User.ip_address', $this->request->clientIp());
        $updateData = [
            'last_login' => date('Y-m-d H:i:s'),
            'ip_address' => $this->request->clientIp(),
        ];
        if ($user !== null) {
            $this->Users->updateQuery()->set($updateData)->where(['id' => $user->get('id')])->execute();
        }
    }

    protected function getCurrentUser()
    {
        $identity = $this->Authentication->getIdentity();
        if ($identity === null) {
            return null;
        }
        return $this->Users->get($identity->get('id'), [
            'contain' => ['UserGroups'],
        ]);
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Registration method – fixed.
     * - Automatically sets user_group_id = 2 (Lecturer).
     * - Handles avatar upload correctly.
     * - Redirects to login with success message.
     */
    public function registration()
    {
        $this->set('title', 'User Registration');
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_group_id'] = 2;
            $data['status'] = 1;
            $data['slug'] = $data['slug'] ?? $this->buildSlug($data['fullname'] ?? $data['email'] ?? 'user');
            $data = $this->handleAvatarUpload($data, null, $data['slug']);
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registration successful. Please login.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    protected function buildSlug(string $value): string
    {
        $slug = Text::slug(strtolower($value));
        if ($slug === '') {
            $slug = 'user';
        }

        $count = $this->Users->find()->where(['slug LIKE' => $slug . '%'])->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        return $slug;
    }

    public function profile($slug = null)
    {
        $this->set('title', 'Account Details');

        $user = $this->getCurrentUser();
        if ($user === null) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
        }

        if ($slug !== null && $slug !== $user->slug) {
            return $this->redirect(['action' => 'profile', $user->slug]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data = $this->handleAvatarUpload($data, $user->avatar ?? null, $user->slug ?? null);
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Account details updated'));
                return $this->redirect(['action' => 'profile', $user->slug]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function update($slug = null, $id = null)
    {
        $this->set('title', 'Update Profile');

        $user = $this->getCurrentUser();
        if ($user === null) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
        }

        if ($slug !== null && $slug !== $user->slug) {
            return $this->redirect(['action' => 'update', $user->slug]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data = $this->handleAvatarUpload($data, $user->avatar ?? null, $user->slug ?? null);
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Account details updated'));
                return $this->redirect(['action' => 'profile', $user->slug]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function removeAvatar($slug = null)
    {
        $this->set('title', 'Remove Profile Picture');

        $user = $this->getCurrentUser();
        if ($user === null) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
        }

        if ($slug !== null && $slug !== $user->slug) {
            return $this->redirect(['action' => 'removeAvatar', $user->slug]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['avatar'] = null;
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Profile picture removed.'));
                return $this->redirect(['action' => 'profile', $user->slug]);
            }
            $this->Flash->error(__('Could not remove profile picture. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function changePassword($slug = null)
    {
        $this->set('title', 'Change Password');
        $user = $this->getCurrentUser();
        if ($user === null) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
        }

        if ($slug !== null && $slug !== $user->slug) {
            return $this->redirect(['action' => 'changePassword', $user->slug]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'password']);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your password has been updated.'));
                return $this->redirect(['action' => 'profile', $user->slug]);
            }
            $this->Flash->error(__('Your password could not be updated. Please, try again.'));
        }
        $this->set(compact('user'));
    }

}