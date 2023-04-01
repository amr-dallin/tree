<?php
App::uses('AppController', 'Controller');

/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 */
class PagesController extends AppController
{
    public $uses = array('Item');
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }
    
    public function display()
    {        
        if ($this->Session->check('Auth.User')) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    
    public function about()
    {
        
    }
    
    public function idea()
    {
        
    }
    
    public function func()
    {
        
    }
    
    public function tech()
    {
        
    }

    public function admin_dashboard()
    {
        
    }
    
    public function admin_settings()
    {
        
    }
    
}
