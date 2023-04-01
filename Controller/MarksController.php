<?php
App::uses('AppController', 'Controller');

/**
 * Marks Controller
 *
 * @property Mark $Mark
 * @property PaginatorComponent $Paginator
 */
class MarksController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
    }
    /**
     * index method
     *
     * @return void
     */
    public function index($person_id = null)
    {
        $person = array();
        if (!empty($person_id)) {
            $person = $this->Mark->Person->getPerson($person_id);
            
            if (empty($person)) {
                throw new NotFoundException(__('Invalid person'));
            }
            
            if ($person['Person']['id'] == $this->Auth->user('User.person_id')) {
                $this->redirect(
                    array(
                        'controller' => 'marks', 
                        'action' => 'index', 
                        'admin' => false
                    )
                );
            }
        }
        
        $this->Mark->collectionSession();
        
        $items = $this->Mark->Item->getItemsMarks();
        $this->set(compact('items', 'person'));
    }


    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            throw new BadRequestException();
        }
        
        $response = false;
        
        $this->Mark->create();
        if ($this->Mark->save($this->request->data)) {
            $response = true;
        }
        
        $this->set('data', $response);
        $this->set('_serialize', 'data');
    }
}
