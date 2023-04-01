<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 */
App::uses('AppHelper', 'View/Helper');


class CollectionHelper extends AppHelper
{
    //var $helpers = array('Session');
    
    public $controller;
    public $action;
    public $album_id;
    public $param;
    public $query;
    public $pass;
    
    
    public function __construct(View $view, $settings = array())
    {
        parent::__construct($view, $settings);
        
        $this->controller = $this->Session->read('Collection.params.controller');
        $this->action = $this->Session->read('Collection.params.action');

        if ($this->Session->check('Collection.params.album_id')) {
            $this->album_id = $this->Session->read('Collection.params.album_id');
        }

        if ($this->Session->check('Collection.params.param')) {
            $this->param = $this->Session->read('Collection.params.param');
        }
        
        if ($this->Session->check('Collection.params.pass')) {
            $this->pass = $this->Session->read('Collection.params.pass.0');
        }
        
        if ($this->Session->check('Collection.query')) {
            $this->query = $this->Session->read('Collection.query');
        }
    }

    public function collectionEditCheck($param = null)
    {
        $result = false;
        
        if (!empty($param)) {
            if (
                $this->controller == 'items' && 
                $this->action == 'admin_index' &&
                $this->param == $param
            ) {
                $result = true;
            }
        } else {
            if (
                $this->controller == 'items' && 
                $this->action == 'admin_index'
            ) {
                $result = true;
            }
        }
        return $result;
    }

    public function collectionAlbumAddEditCheck()
    {
        $result = false;
        if ($this->controller == 'albums' &&
            ($this->action == 'admin_add' || $this->action == 'admin_edit')
        ) {
            $result = true;
        }

        return $result;
    }

    public function collectionBookmarksCheck()
    {
        $result = false;
        if ($this->controller == 'bookmarks' && $this->action == 'index') {
            $result = true;
        }

        return $result;
    }
    
    public function collectionMarksCheck()
    {
        $result = false;
        if ($this->controller == 'marks' && $this->action == 'index') {
            $result = true;
        }

        return $result;
    }
    
    public function collectionUploadsCheck()
    {
        $result = false;
        if ($this->controller == 'items' && $this->action == 'uploads') {
            $result = true;
        }

        return $result;
    }


    public function collectionMediaCheck()
    {
        $result = false;
        if ($this->controller == 'items' && $this->action == 'index') {
            $result = true;
        }

        return $result;
    }
    
    public function collectionAlbumCheck()
    {
        $result = false;
        if (
            $this->controller == 'items' && 
            $this->action == 'index' &&
            !empty($this->album_id)
        ) {
            $result = true;
        }

        return $result;
    }
    
    
}
