<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Authentication\IdentityInterface;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * beforeFilter execution hook.
     *
     * @param \Cake\Event\EventInterface $event An Event instance
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(EventInterface $event)
    {
        // Settings table has been permanently removed. 
        // View templates are supplied with hardcoded defaults matching LALMS metadata.
        $this->set('system_name', 'Lecturer Appointment Letter Management System');
        $this->set('system_abbr', 'LALMS');
        $this->set('system_slogan', 'Automated Letter Generation and Record Management');
        $this->set('organization_name', 'LALMS Academic Institution');
        $this->set('domain_name', 'lalms.edu.my');
        $this->set('email', 'admin@lalms.edu.my');
        $this->set('notification_email', 'noreply@lalms.edu.my');
        $this->set('meta_title', 'LALMS - Lecturer Appointment Letter Management System');
        $this->set('meta_keyword', 'lecturer, appointment, letter, management, cakephp');
        $this->set('meta_subject', 'Appointment Management');
        $this->set('meta_copyright', 'LALMS');
        $this->set('meta_desc', 'Lecturer Appointment Letter Management System built on CakePHP 5');
        $this->set('timezone', 'Asia/Kuala_Lumpur');
        $this->set('author', 'Administrator');
        $this->set('user_reg', 0);
        $this->set('hcaptcha_sitekey', null);
        $this->set('config_2', null);
        $this->set('config_3', null);
        $this->set('version', '1.0.0');
        $this->set('notification', null);
        $this->set('notification_status', 0);
        $this->set('ribbon_title', null);
        $this->set('ribbon_link', null);
        $this->set('ribbon_status', 0);
        $this->set('recrud', '2.1.3');
        $this->set('telegram_bot_token', null);
        $this->set('telegram_chat_id', null);
        
        // Default metatags
        $this->set('metaTitle', 'LALMS - Lecturer Appointment Letter Management System');
        $this->set('metaKeywords', 'lecturer, appointment, letter, management, cakephp');
        $this->set('metaSubject', 'Appointment Management');
        $this->set('metaCopyright', 'LALMS');
        $this->set('metaDescription', 'Lecturer Appointment Letter Management System built on CakePHP 5');

        $identity = $this->Authentication->getIdentity();
        $this->set('currentUser', $identity);
        $this->set('currentUserGroupId', $identity?->get('user_group_id'));
        $this->set('currentUserSlug', $identity?->get('slug'));
        $this->set('isAdmin', $this->isAdmin());
        $this->set('isLecturer', $this->isLecturer());

        $prefix = (string)$this->request->getParam('prefix');
        $controller = $this->request->getParam('controller');

        if ($prefix === 'Lecturer' || $controller === 'LecturerDashboard') {
            $this->viewBuilder()->setLayout('lecturer');

            if (!$identity) {
                return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
            }

            if (!$this->isLecturer()) {
                $this->Flash->error(__('Access denied. Lecturer area only.'));
                return $this->redirect($this->isAdmin()
                    ? ['controller' => 'Dashboards', 'action' => 'index']
                    : ['controller' => 'Users', 'action' => 'login', 'prefix' => false]
                );
            }

            return;
        }

        if ($prefix === 'Admin') {
            if (!$identity || !$this->isAdmin()) {
                if (!$identity) {
                    return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
                }
                $this->Flash->error(__('Access denied. Administrator area only.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
            }

            return;
        }

        $publicControllers = ['Users', 'Pages', 'Contacts'];
        if (!in_array($controller, $publicControllers, true)) {
            if (!$identity || !$this->isAdmin()) {
                if (!$identity) {
                    return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
                }
                $this->Flash->error(__('Administrator access only.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => false]);
            }
        }
    }

    protected function isAdmin(): bool
    {
        $identity = $this->Authentication->getIdentity();
        return $identity !== null && (int)$identity->get('user_group_id') === 1;
    }

    protected function isLecturer(): bool
    {
        $identity = $this->Authentication->getIdentity();
        return $identity !== null && (int)$identity->get('user_group_id') === 2;
    }

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }
}