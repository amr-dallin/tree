<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */
App::uses('Controller', 'Controller');
App::uses('Sanitize', 'Utility');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('CakeTime', 'Utility');
App::uses('HttpSocket', 'Network/Http');

/**./cake i18n extract --exclude Test,Vendor,Plugin --extract-core no
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = array(
        'DebugKit.Toolbar',
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        ),
        'Session',
        'Cookie',
        'Flash',
        'RequestHandler'
    );

    
    public function beforeFilter()
    {
        //Configure AuthComponent
        $this->Auth->loginAction = array(
            'controller' => 'users',
            'action' => 'login',
            'admin' => false
        );
        $this->Auth->loginRedirect = array(
            'controller' => 'items',
            'action' => 'index',
            'admin' => false
        );
        $this->Auth->logoutRedirect = array(
            'controller' => 'users',
            'action' => 'login',
            'admin' => false
        );
        
        //$this->Auth->allow();
        
        if ($this->Session->check('Auth')) {
            $group_id = $this->Session->read('Auth.User.User.group_id');
            
            if ($group_id == 1) {
                Configure::write('debug', 3);
            }
        }
        
        if ($this->Session->check('Auth.User.User.id') &&
            ((time() - date('U', strtotime($this->Session->read('Auth.User.User.visited')))) > 60)
        ) {
            $this->loadModel('User');
            $this->User->id = $this->Session->read('Auth.User.User.id');
            if (!$this->User->exists()) {
                $this->Session->destroy();
                $this->redirect($this->Auth->logout());
            }
            
            $this->User->SaveField('visited', date('Y-m-d H:i:s'), false);
            $this->Session->write('Auth.User.User.visited', date('Y-m-d H:i:s'));
        }
    }

}
