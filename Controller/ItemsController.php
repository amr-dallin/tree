<?php
App::uses('AppController', 'Controller');

/**
 * Items Controller
 *
 * @property Item $Item
 * @property PaginatorComponent $Paginator
 */
class ItemsController extends AppController
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
    public function index()
    {   
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
        
        $this->Item->collectionSession();
        
        $items = $this->Item->getItemsPublished();
        
        $albums = $this->Item->Album->getAlbums();

        $this->set(compact('items', 'albums'));
    }

    public function previous()
    {
        if (!$this->request->is('ajax') ||
            !$this->request->query['quantity']
        ) {
            throw new BadRequestException();
        }
        
        if (!$this->Session->check('Collection.query.quantity')) {
            $this->Session->write(
                'Collection.query.quantity',
                $this->request->query['quantity']
            );
        }
        
        $items = $this->Item->getItemsPrevious();
        
        $this->Session->write(
            'Collection.query.quantity',
            $this->request->query['quantity'] + count($items)
        );
        
        $this->set('items', $items);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id)
    {
        $item = $this->Item->find('first', array(
            'conditions' => array(
                'Item.id' => $id,
                'Item.publish' => true
            ),
            'contain' => array(
                'Photo' => array('conditions' => array('scale' => array(1, 3))),
                'Album',
                'User' => array('Person'),
                'Bookmark' => array('User'),
                'Comment' => array('fields' => array('id')),
                'Mark' => array('Person')
            )
        ));

        if (empty($item)) {
            throw new NotFoundException(__('Invalid item'));
        }
        
        $item['Mark'] = json_encode($item['Mark']);
        
        $comments = $this->Item->Comment->find('threaded', array(
            'conditions' => array('Comment.item_id' => $id),
            'contain' => array('User' => 'Person')
        ));
        
        $collection = $this->Item->collectionAnalysis($item);
        
        $item['Item']['quantity_views']++;
        $this->Item->id = $id;
        $this->Item->saveField('quantity_views', $item['Item']['quantity_views']);

        $this->set(compact('item', 'comments', 'collection'));
    }
    
    public function uploads()
    {
        $this->Item->collectionSession();
        
        $items = $this->Item->getItemsUpload();
        $this->set('items', $items);
    }
    
    public function sendFile($id)
    {
        $item = $this->Item->find(
            'first',
            array(
                'conditions' => array(
                    'Item.id' => $id,
                    'Item.publish' => true
                ),
                'contain' => array(
                    'Photo' => array(
                        'conditions' => array(
                            'scale' => 1
                        )
                        
                    )
                )
            )
        );
        
        if (empty($item)) {
            throw new NotFoundException(__('Invalid item'));
        }
        
        $this->response->file(
            'assets' . DS . 'items' . DS . $item['Photo'][0]['path'],
            array('download' => true)
        );

        return $this->response;
    }

    public function admin_index()
    {
        if (!isset($this->params['param'])) {
            $this->redirect(array(
                'action' => 'index',
                'param' => 'published',
                'admin' => true
            ));
        }
        
        $this->Item->collectionSession();
        
        $items = array();
        switch($this->params['param']) {
            case 'new':
                $items = $this->Item->getItemsNew();
                break;
            case 'not_publish':
                $items = $this->Item->getItemNotPublished();
                break;
            case 'published':
                $items = $this->Item->getItemsPublished();
                break;
            case 'without_album':
                $items = $this->Item->getItemsWithoutAlbum();
                break;
            case 'without_description':
                $items = $this->Item->getItemsWithoutDescription();
                break;
        }

        $this->set('items', $items);
    }

    public function admin_edit($id)
    {
        $item = $this->Item->find('first', array(
            'conditions' => array('Item.id' => $id),
            'contain' => array(
                'Photo' => array('conditions' => array('scale' => 3)),
                'Mark' => array('Person')
            )
        ));

        if (empty($item)) {
            throw new NotFoundException(__('Invalid item'));
        }
        
        $item['Mark'] = json_encode($item['Mark']);
        
        if ($this->request->is(array('post', 'put'))) {
            $this->Item->create();
            if ($this->Item->save($this->request->data, array(
                'fieldList' => array(
                    'id', 'album_id', 'title', 'description', 
                    'start_year', 'end_year', 'position'
                )
            ))) {
                $this->Flash->set(
                    __('The item has been saved.'), 
                    array('params' => array('type' => 'success'))
                );
                
                return $this->redirect($this->redirectEditUrl());
            }
            $this->Flash->set(
                __('The item could not be saved. Please, try again.'), 
                array('params' => array('type' => 'error'))
            );
        } else {
            $this->request->data['Item'] = $item['Item'];
        }
        
        $collection = $this->Item->collectionEditAnalysis($item);
        
        $albums = $this->Item->Album->find('list');
        
        $this->set(compact('item', 'collection', 'albums'));
    }
    
    public function admin_exclusionForAlbum($album_id)
    {
        $response = array(
            'status' => 'error',
            'message' => __('Can not exclude media file from album. Please, try again.')
        );
        
        if ($this->request->is(array('ajax', 'post'))) {
            $item = $this->Item->find('first', array(
                'conditions' => array(
                    'Item.id' => $this->request->data['item_id'],
                    'Item.album_id' => $album_id,
                    'Item.publish' => true
                ),
                'contain' => false
            ));

            if (!empty($item)) {
                $this->Item->create();
                $this->Item->id = $item['Item']['id'];
                if ($this->Item->saveField('album_id', null)) {
                    $response = array(
                        'status' => 'success',
                        'message' => __('Media file excluded from album.')
                    );
                }
            }
        }
        
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    
    private function redirectEditUrl()
    {
        $url = array(
            'controller' => 'items', 'action' => 'index', 'admin' => false
        );

        if ($this->Session->check('Collection')) {
            $collection_session = $this->Session->read('Collection');
            if ($collection_session['params']['controller'] == 'items' &&
                $collection_session['params']['action'] == 'admin_index'
            ) {
                $url = array(
                    'controller' => 'items',
                    'action' => 'index',
                    'admin' => true,
                    'param' => $collection_session['params']['param']
                );
            }
        }
        
        return $url;
    }
    

    public function admin_verification($id)
    {
        $this->request->allowMethod('post');

        $item = $this->Item->find('first', array(
            'conditions' => array(
                'Item.id' => $id,
                'Item.verification' => false,
                'Item.publish' => false
            )
        ));
        if (empty($item)) {
            throw new NotFoundException(__('Invalid item'));
        }

        $this->Item->id = $id;
        if ($this->Item->saveField('verification', 1)) {
            $this->Flash->success(__('Media file verified.'));
        } else {
            $this->Flash->error(__('Media file not verified. Please, try again.'));
        }

        $this->redirect(
            array(
                'controller' => 'items',
                'action' => 'view',
                $id,
                'admin' => true
            )
        );
    }

    public function admin_publish($id)
    {
        $this->request->allowMethod('post');

        $this->Item->id = $id;
        if (!$this->Item->exists()) {
            throw new NotFoundException(__('Invalid item'));
        }

        $item = $this->Item->find('first', array(
            'conditions' => array('Item.id' => $id)
        ));
        if (empty($item)) {
            throw new NotFoundException(__('Invalid item'));
        }

        $data['Item']['verification'] = 1;
        $data['Item']['verified'] = date('c');
        if ($item['Item']['publish']) {
            $data['Item']['publicated'] = null;
            $data['Item']['publish'] = 0;
        } else {
            $data['Item']['publicated'] = date('c');
            $data['Item']['publish'] = 1;
        }

        $this->Item->id = $id;
        if ($this->Item->save($data)) {
            $this->Flash->success(__('Media file verified.'));
        } else {
            $this->Flash->error(__('Media file not verified. Please, try again.'));
        }

        $this->redirect(
            array(
                'controller' => 'items',
                'action' => 'view',
                $id,
                'admin' => true
            )
        );
    }
    
    public function admin_delete()
    {
        $response = array(
            'status' => 'error',
            'message' => __('Something went wrong. Please, repeat again.')
        );
        
        $item_id = '';
        if (isset($this->request->data['item_id'])) {
            $item_id = $this->request->data['item_id'];
        }
        
        $item = $this->Item->find(
            'first', 
            array(
                'conditions' => array(
                    'Item.id' => $item_id
                ),
                'contain' => array('Photo')
            )
        );
        
        if (
            $this->request->is('ajax') && 
            $this->request->is(array('post')) &&
            !empty($item)
        ) {
            $this->Item->create();
            $this->Item->id = $item_id;
            if ($this->Item->delete()) {
                
                $thumbs_50x50 = new File(ITEMS . DS . $item['Item']['thumbs_50x50']);
                if ($thumbs_50x50->exists()) {
                    $thumbs_50x50->delete();
                }
                
                $thumbs_263x180 = new File(ITEMS . DS . $item['Item']['thumbs_263x180']);
                if ($thumbs_263x180->exists()) {
                    $thumbs_263x180->delete();
                }
                
                foreach($item['Photo'] as $photo) {
                    $file = new File(ITEMS . DS . $photo['path']);
                    if ($file->exists()) {
                        $file->delete();
                    }
                }
                
                $response = array(
                    'status' => 'success',
                    'message' => __('Mediafile deleted.')
                );
            }
        }
        
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
