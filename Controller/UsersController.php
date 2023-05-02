<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('login', 'direct', 'initDB');
    }

    public function initDB()
    {
        $group = $this->User->Group;

        // Founder
        $group->id = 1;
        $this->Acl->allow($group, 'controllers');

        // Users
        $group->id = 2;
        $this->Acl->deny($group, 'controllers');
        $this->Acl->allow($group, 'controllers/users/logout');
        $this->Acl->allow($group, 'controllers/users/edit');
        //Albums
        $this->Acl->allow($group, 'controllers/albums/view');
        //Bookmarks
        $this->Acl->allow($group, 'controllers/bookmarks/index');
        $this->Acl->allow($group, 'controllers/bookmarks/action');
        $this->Acl->allow($group, 'controllers/bookmarks/delete');
        //Comments
        $this->Acl->allow($group, 'controllers/comments/add');
        //Items
        $this->Acl->allow($group, 'controllers/items/index');
        $this->Acl->allow($group, 'controllers/items/view');
        $this->Acl->allow($group, 'controllers/items/previous');
        $this->Acl->allow($group, 'controllers/items/uploads');
        $this->Acl->allow($group, 'controllers/items/sendFile');
        //Marks
        $this->Acl->allow($group, 'controllers/marks/index');
        //People
        $this->Acl->allow($group, 'controllers/people/getPeopleJson');
        $this->Acl->allow($group, 'controllers/people/index');
        $this->Acl->allow($group, 'controllers/people/view');
        $this->Acl->allow($group, 'controllers/people/edit');
        $this->Acl->allow($group, 'controllers/people/family');
        
        //Pages
        $this->Acl->allow($group, 'controllers/pages/about');
        $this->Acl->allow($group, 'controllers/pages/idea');
        
        echo "all done";
        exit;
    }
    
    public function login()
    {   
        if ($this->Session->read('Auth.User')) {
            return $this->redirect($this->Auth->redirect());
        }

        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
            $this->User->validator()->remove('username', 'isUnique');
            $this->User->validator()->remove('username', 'isUniqueUsername');
            $this->User->validator()->remove('password', 'regex2Create');
            if ($this->User->validates(array('fieldList' => array('username', 'password')))) {
                $user = $this->User->loginData($this->request->data);
                
                if (!empty($user) && $this->Auth->login($user)) {
                    return $this->redirect($this->Auth->redirectUrl());
                }
                $this->Flash->set(
                    __('Your username or password was incorrect.'), 
                    array('params' => array('type' => 'error'))
                );
            } else {
                $errors = $this->User->validationErrors;
                $this->Flash->set(
                    __('Must correctly complete the highlighted fields'), 
                    array('params' => array('type' => 'error'))
                );
            }
        }
    }
    
    public function logout()
    {
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }
    
    public function direct()
    {        
        if (!isset($this->params['pass'][0]) || 
            empty($this->params['pass'][0])
        ) {
            throw new BadRequestException();
        }
        
        $user = $this->User->loginDirect($this->params['pass'][0]);
        
        if (!empty($user) && $this->Auth->login($user)) {
            return $this->redirect(
                array(
                    'controller' => 'marks', 
                    'action' => 'index', 
                    'admin' => false
                )
            );
        } else {
            $this->Flash->set(
                __('Could not sign in by direct link. It may be damaged. Use the login page'), 
                array('params' => array('type' => 'error'))
            );
            return $this->redirect(
                array( 
                    'action' => 'login', 
                    'admin' => false
                )
            );
        }
    }
    
    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit()
    {
        $user = $this->User->find(
            'first',
            array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('User.id'),
                    'User.block' => false
                ),
                'fields' => array(
                    'User.id', 'User.username', 'User.email', 'User.full_name'
                ),
                'contain' => false
            )
        );


        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['User']['group_id'] = $this->Auth->user('User.group_id');
            $this->request->data['User']['block'] = false;
            
            $this->User->create();
            $this->User->id = $this->Auth->user('User.id');
            if (
                $this->User->save(
                    $this->request->data,
                    array(
                        'validate' => true,
                        'fieldList' => array(
                            'id',
                            'group_id',
                            'username',
                            'password',
                            'confirm_password',
                            'email',
                            'full_name',
                            'block'
                        )
                    )
                )
            ) {
                $this->Auth->login($this->User->loginAuth());
                
                $this->Flash->set(
                    __('Account settings changed.'), 
                    array('params' => array('type' => 'success'))
                );
                return $this->redirect(array(
                    'action' => 'edit', 
                    'admin' => false
                ));
            } else {
                $this->Flash->set(
                    __('Account settings are not changed. Please, repeat again.'), 
                    array('params' => array('type' => 'error'))
                );
            }
        } else {
            $this->request->data = $user;
        }
    }

    public function admin_index()
    {
        $users = $this->User->find(
            'all',
            array(
                'conditions' => array(
                    'User.group_id !=' => 1
                ),
                'contain' => array(
                    'Person'
                )
            )
        );
        
        $this->set('users', $users);
    }
    
    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        if ($this->request->is('post')) {
            $this->request->data['User']['group_id'] = 2;
            $this->User->create();
            if (
                $this->User->save(
                    $this->request->data,
                    array(
                        'validate' => true,
                        'fieldList' => array(
                            'group_id', 
                            'person_id', 
                            'username', 
                            'password',
                            'confirm_password',
                            'email',
                            'full_name'
                        )
                    )
                )
            ) {
                $this->Flash->set(
                    __('The user has been saved.'), 
                    array('params' => array('type' => 'success'))
                );
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(
                    __('The user could not be saved. Please, try again.'), 
                    array('params' => array('type' => 'error'))
                );
            }
        }
        
        $people = $this->User->Person->find('list', array(
            'conditions' => array(
                'Person.id !=' => $this->User->find(
                    'list',
                    array(
                        'conditions' => array(
                            'User.person_id !=' => null
                        ),
                        'fields' => 'person_id',
                        'contain' => false
                    )
                )
            ),
            'fields' => array('full_name'),
            'contain' => false
        ));
        
        $this->set('people', $people);
    }
    
    public function admin_edit($id = null)
    {
        $user = $this->User->find(
            'first',
            array(
                'conditions' => array(
                    'User.id' => $id,
                    'User.group_id' => 2
                ),
                'fields' => array(
                    'id',
                    'group_id',
                    'person_id',
                    'username',
                    'full_name',
                    'email'
                ),
                'contain' => false
            )
        );
        
        if (empty($user)) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['User']['group_id'] = 2;
            $this->request->data['User']['block'] = false;
            if (
                $this->User->save(
                    $this->request->data,
                    array(
                        'validate' => true,
                        'fieldList' => array(
                            'id',
                            'group_id',
                            'username',
                            'person_id',
                            'password',
                            'confirm_password',
                            'full_name',
                            'email',
                            'block'
                        )
                    )
                )
            ) {
                $this->Flash->set(
                    __('Account settings changed.'), 
                    array('params' => array('type' => 'success'))
                );
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(
                    __('Account settings are not changed. Please, repeat again.'), 
                    array('params' => array('type' => 'error'))
                );
            }
        } else {
            $this->request->data = $user;
        }
        
        $people = $this->User->Person->find('list', array(
            'conditions' => array(
                'Person.id !=' => $this->User->find(
                    'list',
                    array(
                        'conditions' => array(
                            'AND' => array(
                                'User.id !=' => $user['User']['id'],
                                'User.person_id !=' => null
                            )
                        ),
                        'fields' => 'person_id',
                        'contain' => false
                    )
                )
            ),
            'fields' => array('full_name'),
            'contain' => false
        ));
        
        $this->set(compact('user', 'people'));
    }
    
    public function admin_view($id)
    {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }
}
