<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $this->loadModel('Posts');

        $this->loadModel('Users');

        if ($this->request->isAjax()) {

            $post = $this->Posts->newEmptyEntity();

            if($this->request->is('post')) {

                if($this->request->getData('fetch_posts')==1) {

                    // $query = $this->Users->find()->where(['Users.email' => $this->request->getData('email')])->count();

                    $posts = $this->Posts->find('all')->contain(['Users'])->where(['users.id' => $this->Auth->user('id')]);
                    $output = '';


                    foreach($posts as $post) {

                        $output.='<div class="col-sm-9 mt-3">';
                        $output.='<h2>'.$post->title.'</h2>';
                        $output.='<img src="img/'.$post->image.'" width="200" height="200">';
                        $output.='<p>'.$post->body.'</p>';
                        $output.='</div>';
                    }


                    $result = json_encode(array('success' => 1, 'posts' => $output));

                    return $this->response->withType('json')->withStringBody($result);
                } else {

                    $data = $this->request->getData();
                    $image = $this->request->getData("image");

                    $fileName = $image->getClientFilename();
                    $fileType = $image->getClientMediaType();

                    if ($fileType == "image/png" || $fileType == "image/jpeg" || $fileType == "image/jpg") {
                        $imagePath = WWW_ROOT . "img/" . $fileName;
                        $image->moveTo($imagePath);
                        $data["image"] = $fileName;
                    }

                    $post = $this->Posts->patchEntity($post, $data);

                    if($this->Posts->save($post)) {

                        $result = json_encode(array('success' => 1, 'message' => 'Successfully added'));

                        return $this->response->withType('json')->withStringBody($result);
                    } 

                    $result = json_encode(array('success' => 0));

                    return $this->response->withType('json')->withStringBody($result);
                }
            }
        }

        $this->set('id', $this->Auth->user('id'));
        // $user = $this->Auth->user('role_user')[0];
        // var_dump($user['role_id']);

    }

    public function contact() {
        
    }

    public function test() {

        if($this->request->is('post')) {

            $users = $this->Users->find('all');

            // $result = json_encode(array('users' => $users));

            // return $this->response->withType('json')->withStringBody($result);
            $output = '<table class="table">
                        <thead>
                          <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>';
            foreach($users as $user) {

                $output.='<tr>';
                $output.='<td>'.$user->fname.'</td>';
                $output.='<td>'.$user->lname.'</td>';
                $output.='<td>'.$user->address.'</td>';
                $output.='<td>'.$user->email.'</td>';
                $output.='<td>'.$user->phone.'</td>';
                $output.='<td><button class="btn btn-primary edit_user" data-id="'.$user['id'].'" data-fname="'.$user['fname'].'" data-lname="'.$user['lname'].'" data-address="'.$user['address'].'" data-email="'.$user['email'].'" data-phone="'.$user['phone'].'">Edit</button> <button class="btn btn-danger delete_user" data-id="'.$user['id'].'">Delete</button></td>';
                 $output.='</tr>';
            }

            $output.='</table>';

            $result = json_encode(array('users' => $output));

            return $this->response->withType('json')->withStringBody($result);

        }
    }

    public function edit() {

        $id = $this->request->getData('userid');

        $user = $this->Users->get($id);

        if($this->request->is('post')) {

            $user->fname = $this->request->getData('fname');
            $user->lname = $this->request->getData('lname');
            $user->address = $this->request->getData('address');
            $user->email = $this->request->getData('email');
            $user->phone = $this->request->getData('phone');

            if($this->Users->save($user)) {

                $result = json_encode(array('success' => 1));

                return $this->response->withType('json')->withStringBody($result);
            }
        }
    }

    public function delete() {

        $user = $this->Users->get($this->request->getData('id'));

        if($this->Users->delete($user)) {

            $result = json_encode(array('success' => 1, 'message' => 'Successfully deleted'));

            return $this->response->withType('json')->withStringBody($result);
        }
    }
}
