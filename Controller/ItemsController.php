<?php
App::uses('AppController', 'Controller');

use \Gumlet\ImageResize;

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

    public function admin_add()
    {
        if ($this->request->is(array('post'))) {

            $inputPath = $this->request->data['Item']['file']['tmp_name'];
            $this->request->data['Item']['user_id'] = AuthComponent::user('User.id');
            $this->request->data['Item']['type'] = 1;
            //$this->request->data['Item']['verification'] = 1;
            //$this->request->data['Item']['verified'] = date('Y-m-d H:i:s');
            //$this->request->data['Item']['publish'] = 1;
            //$this->request->data['Item']['published'] = date('Y-m-d H:i:s');
            
            $width = getimagesize($inputPath)[0];
            $height = getimagesize($inputPath)[1];
            $this->request->data['Item']['orientation'] = $this->orientation($width, $height);
            
            $image = new ImageResize($inputPath);
            
            // Миниатюра для коллекций на странице items/view
            $thumbs_50x50_path = $this->outputPath($file);
            $image->crop(50, 50);
            if ($image->save(ITEMS . DS . $thumbs_50x50_path)) {
                $this->request->data['Item']['thumbs_50x50'] = $thumbs_50x50_path;
            }
            
            // Обложка для альбома
            $thumbs_263x180_path = $this->outputPath($file);
            $image->crop(263, 180);
            if ($image->save(ITEMS . DS . $thumbs_263x180_path)) {
                $this->request->data['Item']['thumbs_263x180'] = $thumbs_263x180_path;
            }
            
            // Оригинал изображения. То что скачивается
            $original_path = $this->outputPath($file);
            $image->resize($width, $height);
            if ($image->save(ITEMS . DS . $original_path)) {
                $this->request->data['Item']['Photo'][] = array(
                    'path' => $original_path,
                    'scale' => 1,
                    'width' => $width,
                    'height' => $height,
                    'size' => filesize(ITEMS . DS . $original_path)
                );
            }
            
            // Изображение с высотой 200px. Показывается в rowGrids
            $height_200_path = $this->outputPath($file);
            $image->resizeToHeight(200);
            if ($image->save(ITEMS . DS . $height_200_path)) {
                $this->request->data['Item']['Photo'][] = array(
                    'path' => $height_200_path,
                    'scale' => 2,
                    'width' => getimagesize(ITEMS . DS . $height_200_path)[0],
                    'height' => 200,
                    'size' => filesize(ITEMS . DS . $height_200_path)
                );
            }
            
            // Изображение с высотой 400px. Показывается на странице view
            $height_400_path = $this->outputPath($file);
            $image->resizeToHeight(400);
            if ($image->save(ITEMS . DS . $height_400_path)) {
                $this->request->data['Item']['Photo'][] = array(
                    'path' => $height_400_path,
                    'scale' => 3,
                    'width' => getimagesize(ITEMS . DS . $height_400_path)[0],
                    'height' => 400,
                    'size' => filesize(ITEMS . DS . $height_400_path)
                );
            }

            $this->Item->create();
            if ($this->Item->saveAssociated($this->request->data, array('deep' => true))) {
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
        
        $albums = $this->Item->Album->find('list');
        
        $this->set(compact('item', 'albums'));
    }

    public function admin_index()
    {
        if (!isset($this->params['pass'][0])) {
            $this->redirect(array(
                'action' => 'index',
                'param' => 'published',
                'admin' => true
            ));
        }
        
        $this->Item->collectionSession();
        
        $items = array();
        switch($this->params['pass'][0]) {
            case 'new':
                $items = $this->Item->getItemsNew();
                break;
            case 'not_published':
                $items = $this->Item->getItemsNotPublished();
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
            if ($this->Item->save($this->request->data)) {
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
            if (
                $collection_session['params']['controller'] == 'items' &&
                $collection_session['params']['action'] == 'admin_index'
            ) {
                $url = array(
                    'controller' => 'items',
                    'action' => 'index',
                    'admin' => true,
                    $collection_session['params']['pass'][0]
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

    private function outputPath($file)
    {
        $dirPath = $this->dirPath();
        $dir = new Folder(ITEMS . DS . $dirPath);
        if (is_null($dir->path)) {
            $dir->create(ITEMS . DS . $dirPath);
        }
        
        return $dirPath . DS . $this->fileName($file);
    }
    
    /*
    Генерация директорий, с указанием глубины
    */
    private function dirPath()
    {
        $dir = '';
        $dir_separator = DS;
        for ($i = 1; $i <= DEPTH; $i++)
        {
            if ($i == DEPTH) {
                $dir_separator = '';
            }
            $dir .= substr(md5(microtime()), mt_rand(0, 30), 2) . $dir_separator;
        }
        
        return $dir;
    }
    
    /*
    Генерация имени файла
    */
    private function fileName($file)
    {
        return md5($file . substr(md5(microtime()), mt_rand(0, 30), 5)) . '.jpg';
    }
    
    /**
     * Определение ориентации изображения
     * @param type $file
     * 
     */
    private function orientation($width, $height)
    {   
        if ($width > $height) {
            $orientation = 1; //горизонтальное
        } elseif ($width < $height) {
            $orientation = 2; //вертикальное
        } else {
            $orientation = 3; //квадратное
        }
        
        return $orientation;
    }
}
