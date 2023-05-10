<?php
App::uses('AppController', 'Controller');

/**
 * People Controller
 *
 * @property Person $Person
 * @property PaginatorComponent $Paginator
 */
class PeopleController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
    }
    
    public function getPeopleJson()
    {
        if (!$this->request->is('ajax') || !$this->request->is('get')) {
            throw new BadRequestException();
        }
        
        $people = $this->Person->find(
            'all', 
            array(
                'order' => array(
                    'last_name' => 'ASC',
                    'first_name' => 'ASC'
                ),
                'contain' => false
            )
        );
        
        $this->set('data', $people);
        $this->set('_serialize', 'data');
    }
    
    public function index()
    {
        $this->set('people', $this->Person->getPeople());
    }
    
    public function view($id = null)
    {
        $person = $this->Person->find(
            'first',
            array(
                'conditions' => array('Person.id' => $id),
                'contain' => false
            )
        );
        
        if (empty($person)) {
            throw new NotFoundException(__('Invalid person'));
        }
        
        $this->set('person', $person);
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
        $person = $this->Person->find(
            'first',
            array(
                'conditions' => array(
                    'Person.id' => $this->Auth->user('User.person_id')
                ),
                'contain' => false
            )
        );
        if (empty($person)) {
            throw new NotFoundException(__('Invalid person'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            $this->Person->create();
            $this->Person->id = $this->Auth->user('User.person_id');
            if (
                $this->Person->save(
                    $this->request->data,
                    array('validate' => true)
                )
            ) {
                $this->Auth->login($this->Person->User->loginAuth());
                
                $this->Flash->set(
                    __('The person has been saved.'), 
                    array('params' => array('type' => 'success'))
                );
                return $this->redirect(array('action' => 'edit'));
            } else {
                $this->Flash->set(
                    __('The person could not be saved. Please, try again.'), 
                    array('params' => array('type' => 'error'))
                );
            }
        } else {
            $this->request->data = $person;
        }
    }
    
    public function family($id = null)
    {
        $person_id = $this->Auth->user('User.person_id');
        
        if (!empty($id)) {
            if ($id == $this->Auth->user('User.person_id')) {
                $this->redirect(
                    array(
                        'controller' => 'people',
                        'action' => 'family',
                        'admin' => false
                    )
                );
            }

            $person_id = $id;
        }
        
        $family = $this->Person->getFamily($person_id);
        

        if (empty($family)) {
            throw new NotFoundException(__('Invalid person'));
        }
        
        $this->set('family', $family);
    }
    
    
    public function admin_index()
    {
        $people = $this->Person->find(
            'all', 
            array(
                'contain' => array(
                    'User',
                    'Mark'
                )
            )
        );
        
        $this->set('people', $people);
    }

    /**
     * add method
     *
     * @return void
     */
    public function admin_add()
    {
        if ($this->request->is('post')) {
            $this->Person->create();
            if ($this->Person->save($this->request->data)) {
                $this->Flash->set(
                    __('The person has been saved.'), 
                    array('params' => array('type' => 'success'))
                );
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(
                    __('The person could not be saved. Please, try again.'), 
                    array('params' => array('type' => 'error'))
                );
            }
        }
        
        $fathers = $this->Person->find(
            'list',
            array(
                'conditions' => array(
                    'Person.gender' => 1
                ),
                'fields' => array('full_name')
            )
        );
        $mothers = $this->Person->find(
            'list',
            array(
                'conditions' => array(
                    'Person.gender' => 2
                ),
                'fields' => array('full_name')
            )
        );
        $spouses = $this->Person->find('list', array('fields' => array('full_name')));
        
        $this->set(compact('users', 'fathers', 'mothers', 'spouses'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null)
    {
        if (!$this->Person->exists($id)) {
            throw new NotFoundException(__('Invalid person'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Person->save($this->request->data)) {
                $this->Flash->set(
                    __('The person has been saved.'), 
                    array('params' => array('type' => 'success'))
                );
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->set(
                    __('The person could not be saved. Please, try again.'), 
                    array('params' => array('type' => 'error'))
                );
            }
        } else {
            $options = array('conditions' => array('Person.' . $this->Person->primaryKey => $id));
            $this->request->data = $this->Person->find('first', $options);
        }
        
        $fathers = $this->Person->find(
            'list',
            array(
                'conditions' => array(
                    'Person.gender' => 1,
                    'Person.id !=' => $id 
                ),
                'fields' => array('full_name')
            )
        );
        $mothers = $this->Person->find(
            'list',
            array(
                'conditions' => array(
                    'Person.gender' => 2
                ),
                'fields' => array('full_name')
            )
        );
        
        $spouses = $this->Person->find(
            'list',
            array(
                'conditions' => array(
                    'Person.id !=' => $id
                ),
                'fields' => array('full_name')
            )
        );
        
        $this->set(compact('users', 'fathers', 'mothers', 'spouses'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null)
    {
        $this->Person->id = $id;
        if (!$this->Person->exists()) {
            throw new NotFoundException(__('Invalid person'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Person->delete()) {
            $this->Flash->success(__('The person has been deleted.'));
        } else {
            $this->Flash->error(__('The person could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'admin_index'));
    }
}
