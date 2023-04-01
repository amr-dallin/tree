<?php
App::uses('AppController', 'Controller');

/**
 * Albums Controller
 *
 * @property Album $Album
 * @property PaginatorComponent $Paginator
 */
class AlbumsController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {    
        $album = $this->Album->find('first', array(
            'conditions' => array('Album.id' => $id),
            'contain' => array(
                'Item' => array(
                    'fields' => array('COUNT(*) as quantity')
                )
            )
        ));
        
        if (empty($album)) {
            throw new NotFoundException(__('Invalid album'));
        }
        
        $this->Album->collectionDefaultSession();
        SessionComponent::write('Collection.params.album_id', $id);

        $items = $this->Album->Item->getItemsAlbum($id);
        
        $this->set(compact('album', 'items'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->Album->collectionSession();
        
        if ($this->request->is('post')) {
            $this->Album->create();
            if ($this->Album->saveAssociated($this->request->data, array(
                'deep' => true , 'atomic' => true)
            )) {
                $this->Flash->set(
                    __('The album has been saved.'), 
                    array('params' => array('type' => 'success'))
                );
                return $this->redirect(array(
                    'controller' => 'items', 
                    'action' => 'index', 
                    'admin' => false
                ));
            } else {
                $this->Flash->set(
                    __('The album could not be saved. Please, try again.'), 
                    array('params' => array('type' => 'error'))
                );
            }
        }
        
        $items = $this->Album->Item->getItemsWithoutAlbum();
        $this->set('items', $items);
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null)
    {
        if (!$this->Album->exists($id)) {
            throw new NotFoundException(__('Invalid album'));
        }
        
        $this->Album->collectionSession();
        
        if ($this->request->is(array('post', 'put'))) {
            $this->Album->id = $id;
            if ($this->Album->saveAssociated($this->request->data, 
                array('deep' => true , 'atomic' => true)
            )) {
                $this->Flash->set(__('The album has been saved.'), array(
                    'params' => array('type' => 'success')
                ));
                return $this->redirect(array(
                    'action' => 'view', $id, 'admin' => false
                ));
            } else {
                $this->Flash->set(
                    __('The album could not be saved. Please, try again.'), 
                    array('params' => array('type' => 'error'))
                );
            }
        } else {
            $options = array('conditions' => array('Album.' . $this->Album->primaryKey => $id));
            $this->request->data = $this->Album->find('first', $options);
        }
        
        $items = $items = $this->Album->Item->getItemsWithoutAlbum();
        $this->set('items', $items);
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
        $this->Album->id = $id;
        if (!$this->Album->exists()) {
            throw new NotFoundException(__('Invalid album'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Album->delete()) {
            $this->Flash->set(
                __('The album has been deleted.'), 
                array('params' => array('type' => 'success'))
            );
        } else {
            $this->Flash->set(
                __('The album could not be deleted. Please, try again.'), 
                array('params' => array('type' => 'error'))
            );
        }
        return $this->redirect(array(
            'controller' => 'items', 'action' => 'index', 'admin' => false
        ));
    }
}
