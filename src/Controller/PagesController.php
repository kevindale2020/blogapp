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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function register() {

        $this->loadModel('Users');

        $this->loadModel('RoleUser');

        // $user = $this->Users->newEmptyEntity();

        if($this->request->isAjax()) {

            // $user = $this->Users->newEmptyEntity();

            if($this->request->is('post')) {

                // $user->email = $this->request->getData('email');
                // $user->password = $this->request->getData('pass1');

                // // check if email already exists
                // $query = $this->Users->find()->where(['Users.email' => $this->request->getData('email')])->count();

                // if($query) {

                //     $result = json_encode(array('success' => 0));

                //     return $this->response->withType('json')->withStringBody($result);
                // }

                // if($this->Users->save($user)) {

                //     $result = json_encode(array('success' => 1));

                //     return $this->response->withType('json')->withStringBody($result);
                // }

                // $user = $this->Users->patchEntity($user, $this->request->getData());

                // $save = $this->Users->save($user);

                // $user_id = $save->id;

                // $data['role_id'] = 5;
                // $data['user_id'] = $user_id;

                // $roleuser = $this->RoleUser->newEmptyEntity();

                // $roleuser = $this->RoleUser->patchEntity($roleuser, $data);

                // if($this->RoleUser->save($roleuser)) {

                //     $result = json_encode(array('success' => 1, 'message' => $user->id));

                //     return $this->response->withType('json')->withStringBody($result);
                // }
                $data = [
                    'email' => $this->request->getData('email'),
                    'password' => $this->request->getData('password'),
                    'role_user' => [
                        'user_id' => 1,
                        'role_id' => 6
                    ]
                ];

                $users = $this->getTableLocator()->get('Users');

                $user = $users->newEntity($data, [
                    'associated' => ['RoleUser']
                ]);

                if($users->save($user)) {

                    $result = json_encode(array('success' => 1, 'message' => $user->id));

                    return $this->response->withType('json')->withStringBody($result);
                }
            }
        }
    }

    public function login() {
        
        if($this->request->is('post')) {

            $user = $this->Auth->identify();

            if($user) {

                $this->Auth->setUser($user);

                $result = json_encode(array('success' => 1));

                return $this->response->withType('json')->withStringBody($result);
            }

            $result = json_encode(array('success' => 0));

            return $this->response->withType('json')->withStringBody($result);
        }
    }

    public function logout() {

        return $this->redirect($this->Auth->logout());
    }
}
