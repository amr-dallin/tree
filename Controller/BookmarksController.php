<?php
App::uses('AppController', 'Controller');

/**
 * Bookmarks Controller
 *
 * @property Bookmark $Bookmark
 * @property PaginatorComponent $Paginator
 */
class BookmarksController extends AppController
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
        $this->Bookmark->collectionSession();
        $items = $this->Bookmark->Item->getItemsBookmarks();
        $this->set('items', $items);
    }
    
    
    public function action()
    {
        $item_id = '';
        if (isset($this->request->data['item_id'])) {
            $item_id = $this->request->data['item_id'];
        }
        
        $item = $this->Bookmark->Item->find('first', array(
            'conditions' => array(
                'Item.id' => $item_id,
                'Item.publish' => true
            ),
            'contain' => array('Bookmark')
        ));
        
        if (!$this->request->is('ajax') || 
            !$this->request->is(array('post', 'put')) ||
            empty($item)
        ) {
            $response = array(
                'status' => 'error',
                'message' => __('Something went wrong. Please, repeat again.')
            );
        } else {
            $exist = '';
            foreach($item['Bookmark'] as $key => $bookmark) {
                if ($bookmark['user_id'] == $this->Auth->user('User.id')) {
                    $exist = $item['Bookmark'][$key];
                    break;
                }
            }
            
            if (empty($exist)) {
                $data = array(
                    'user_id' => $this->Auth->user('User.id'),
                    'item_id' => $item_id
                );
                $this->Bookmark->create();
                $this->Bookmark->save($data);

                $response = array(
                    'status' => 'success',
                    'action' => 1,
                    'quantity' => count($item['Bookmark']) + 1,
                    'message' => __('Mediafile added to bookmarks'),
                    'title' => __('Remove from bookmarks')
                );
            } else {
                $this->Bookmark->create();
                $this->Bookmark->id = $exist['id'];
                $this->Bookmark->delete();
                
                $quantity = '';
                if ((count($item['Bookmark']) - 1) > 0) {
                    $quantity = count($item['Bookmark']) - 1;
                }
                
                $response = array(
                    'status' => 'success',
                    'action' => 0,
                    'quantity' => $quantity,
                    'message' => __('Mediafile removed from bookmarks'),
                    'title' => __('Add to bookmarks')
                );
            }
        }
        
        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
