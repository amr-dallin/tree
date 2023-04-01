<?php
App::uses('AppModel', 'Model');

/**
 * Item Model
 *
 * @property User $User
 * @property Album $Album
 * @property Comment $Comment
 * @property Photo $Photo
 */
class Item extends AppModel
{
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'user_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'type' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'orientation' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'thumbs_75x75' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'thumbs_150x150' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'verification' => array(
            'boolean' => array(
                'rule' => array('boolean'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'publish' => array(
            'boolean' => array(
                'rule' => array('boolean'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Album' => array(
            'className' => 'Album',
            'foreignKey' => 'album_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Photo' => array(
            'className' => 'Photo',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Bookmark' => array(
            'className' => 'Bookmark',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Mark' => array(
            'className' => 'Mark',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    
    public function beforeSave($options = array())
    {
        if (empty($this->data['Item']['start_year'])) {
            unset($this->data['Item']['start_year']);
        }
        
        if (empty($this->data['Item']['end_year'])) {
            unset($this->data['Item']['end_year']);
        }
        
        return $this->data;
    }
    
    private function limit()
    {
        $limit = LIMIT;
        if (property_exists(Router::getRequest(), 'query')) {
            $quantity = Router::getRequest()->query('quantity');
            
            if (!empty($quantity)) {
                $limit = $quantity;
            }
        }

        return $limit;
    }
    
    /************************ ITEMS FOR ROW GRIDS ***************************/
    
    private function getItems($conditions, $offset = false, $order = null)
    {
        if (empty($order)) {
            $order = array('id' => 'DESC');
        }
        
        $limit = $this->limit();
        
        if ($offset && SessionComponent::check('Collection.query.quantity')) {
            $offset = SessionComponent::read('Collection.query.quantity');
            $limit = LIMIT;
        }
        
        return $this->find('all',
            array(
                'conditions' => $conditions,
                'contain' => array(
                    'Photo' => array('conditions' => array('scale' => 2)),
                    'Comment',
                    'Bookmark' => array(
                        'conditions' => array(
                            'user_id' => AuthComponent::user('User.id')
                        )
                    )
                ),
                'limit' => $limit,
                'offset' => $offset,
                'order' => $order
            )
        );
    }
    
    public function getItemsPrevious()
    {
        $items = '';
        if ($this->collectionMediaCheck()) {
            if (SessionComponent::check('Collection.params.album_id')) {
                $items = $this->getItemsAlbum(null, true);
            } else {
                $items = $this->getItemsPublished(true);
            } 
        }
        
        if ($this->collectionAlbumAddEditCheck()) {
            $items = $this->getItemsWithoutAlbum(true);
        }
        
        if ($this->collectionBookmarksCheck()) {
            $items = $this->getItemsBookmarks(true);
        }
        
        if ($this->collectionMarksCheck()) {
            $items = $this->getItemsMarks(true);
        }
        
        if ($this->collectionEditCheck('new')) {
            $items = $this->getItemsNew(true);
        }
        
        if ($this->collectionEditCheck('not_published')) {
            $items = $this->getItemsNotPublished(true);
        }
        
        if ($this->collectionEditCheck('published')) {
            $items = $this->getItemsPublished(true);
        }
        
        if ($this->collectionEditCheck('without_album')) {
            $items = $this->getItemsWithoutAlbum(true);
        }
        
        if ($this->collectionEditCheck('without_description')) {
            $items = $this->getItemsWithoutDescription(true);
        }
        
        return $items;
    }
    
    public function getItemsAlbum($album_id, $offset = false)
    {
        if ($album_id == null) {
            $album_id = SessionComponent::read('Collection.params.album_id');
        }
        
        $conditions = array(
            'Item.album_id' => $album_id,
            'Item.publish' => true
        );
        
        return $this->getItems($conditions, $offset);
    }
    
    public function getItemsNew($offset = false)
    {
        $conditions = array('Item.verification' => false);
        return $this->getItems($conditions, $offset);
    }
    
    public function getItemsNotPublished($offset = false)
    {
        $conditions = array('Item.publish' => false);
        return $this->getItems($conditions, $offset);
    }
    
    public function getItemsPublished($offset = false)
    {
        $conditions = array('Item.publish' => true);
        return $this->getItems($conditions, $offset);
    }
    
    public function getItemsWithoutAlbum($offset = false)
    {
        $conditions = array('Item.publish' => true, 'Item.album_id' => null);
        return $this->getItems($conditions, $offset);
    }
    
    public function getItemsWithoutDescription($offset = false)
    {
        $conditions = array(
            'Item.publish' => true,
            'Item.title' => null,
            'Item.description' => null,
            'Item.start_year' => null,
            'Item.end_year' => null
        );
        return $this->getItems($conditions, $offset);
    }
    
    public function getItemsUpload($offset = false)
    {
        $conditions = array('Item.user_id' => AuthComponent::user('User.id'));
        return $this->getItems($conditions, $offset);
    }
    
    public function getItemsBookmarks($offset = false)
    {
        $bookmarks = $this->Bookmark->find('list', array(
            'conditions' => array(
                'user_id' => AuthComponent::user('User.id')
            ),
            'fields' => array('Bookmark.item_id'),
            'order' => array('Bookmark.created DESC'),
            'contain' => false
        ));
        
        $items = '';
        if (!empty($bookmarks)) {
            $conditions = array('Item.id' => $bookmarks);
            $order = "FIELD(Item.id," . implode(',', $bookmarks). ")";
            $items = $this->getItems($conditions, $offset, $order);
        }
        
        return $items;
    }
    
    public function getItemsMarks($offset = false)
    {
        $person_id = AuthComponent::user('User.person_id');
        if (SessionComponent::check('Collection.params.pass.0')) {
            $person_id = SessionComponent::read('Collection.params.pass.0');
        }
        
        $marks = $this->Mark->find('list', array(
            'conditions' => array(
                'person_id' => $person_id
            ),
            'fields' => array('Mark.item_id'),
            'order' => array('Mark.created DESC'),
            'contain' => false
        ));
        
        $items = '';
        if (!empty($marks)) {
            $conditions = array('Item.id' => $marks);
            $order = "FIELD(Item.id," . implode(',', $marks). ")";
            $items = $this->getItems($conditions, $offset, $order);
        }
        
        return $items;
    }
    
    /************************ COLLECTIONS **********************************/
    
    public function collectionAnalysis($item)
    {
        $collection = array();
        
        if (SessionComponent::check('Collection')) {
            if ($this->collectionBookmarksCheck()) {
                $collection = $this->getCollectionBookmarks($item['Item']['id']);
            }
            
            if ($this->collectionMarksCheck()) {
                $collection = $this->getCollectionMarks($item['Item']['id']);
            }
            
            if ($this->collectionUploadsCheck()) {
                $collection = $this->getCollectionUploads($item);
            }
            
            if ($this->collectionMediaCheck()) {
                $collection = $this->getCollectionMedia($item);
            }
        }
        
        if (empty($collection)) {
            //Если медиафайл не входит в коллекцию, указанную в сессии или сессия пуста
            $this->collectionDefaultSession();
            $conditions = array('Item.publish' => true);
            $collection = $this->getCollection($conditions, $item['Item']['id']);
        }
        
        return $collection;
    }
    
    public function collectionEditAnalysis($item)
    {
        $collection = array();
        
        if ($this->collectionEditCheck('new')) {
            $collection = $this->getCollectionItemsNew($item);
        }
        
        if ($this->collectionEditCheck('not_published')) {
            $collection = $this->getCollectionItemsNotPublished($item);
        }
        
        if ($this->collectionEditCheck('published')) {
            $collection = $this->getCollectionItemsPublished($item);
        }
        
        if ($this->collectionEditCheck('without_album')) {
            $collection = $this->getCollectionItemsWithoutAlbum($item);
        }
        
        if ($this->collectionEditCheck('without_description')) {
            $collection = $this->getCollectionItemsWithoutDescription($item);
        }

        return $collection;
    }
    
    private function getCollection($conditions, $id)
    {
        $collection['itemsPrev'] = array_reverse($this->find('all', array(
            'conditions' => array('Item.id >' => $id, $conditions),
            'fields' => array('id', 'thumbs_50x50'),
            'contain' => false,
            'order' => array('Item.id' => 'ASC'),
            'limit' => 3
        )));
        
        $collection['itemsNext'] = $this->find('all', array(
            'conditions' => array('Item.id <' => $id, $conditions),
            'fields' => array('id', 'thumbs_50x50'),
            'contain' => false,
            'order' => array('id' => 'DESC'),
            'limit' => 3
        ));
        
        return $collection;
    }
    
    private function getCollectionMedia($item)
    {
        $collection = '';
        if (SessionComponent::check('Collection.params.album_id')) {
            $collection = $this->getCollectionItemsAlbum($item);
        } else {
            $collection = $this->getCollectionItemsPublished($item);
        }
        
        return $collection;
    }
    
    private function getCollectionItemsAlbum($item)
    {
        $collection = '';
        $album_id = SessionComponent::read('Collection.params.album_id');
        if ($item['Item']['album_id'] == $album_id) {
            $conditions = array(
                'Item.publish' => true,
                'Item.album_id' => $album_id
            );
            $collection = $this->getCollection($conditions, $item['Item']['id']);
        }
        
        return $collection;
    }
    
    private function getCollectionBookmarks($id)
    {
        $items = $this->Bookmark->find('all', array(
            'conditions' => array(
                'Bookmark.user_id' => AuthComponent::user('User.id')
            ),
            'order' => array('Bookmark.created DESC'),
            'contain' => array(
                'Item' => array(
                    'fields' => array('id', 'thumbs_50x50', 'publish')
                )
            )
        ));
        
        //Поиск текущего медиафайла
        $currentItemPosition = '';
        foreach($items as $key => $item) {
            if ($item['Item']['id'] == $id) {
                $currentItemPosition = $key;
                break;
            }
        }
        
        $collection = array('itemsPrev', 'itemsNext');
        
        if ($currentItemPosition !== '') {
            //Предыдущие медиафайлы относительно выбранного
            $itemsPrev = array();
            for ($i = ($currentItemPosition - 1); $i >= 0; $i--) {
                if ($items[$i]['Item']['publish']) {
                    $itemsPrev[]['Item'] = $items[$i]['Item'];

                    if (count($itemsPrev) == 3) {
                        break;
                    }
                }
            }
            
            if (!empty($itemsPrev)) {
                $collection['itemsPrev'] = array_reverse($itemsPrev);
            }
            
            //Следующие медиафайлы
            $itemsNext = array();
            for ($i = ($currentItemPosition + 1); $i < count($items); $i++) {
                if ($items[$i]['Item']['publish']) {
                    $itemsNext[]['Item'] = $items[$i]['Item'];

                    if (count($itemsNext) == 3) {
                        break;
                    }
                }
            }
            
            if (!empty($itemsNext)) {
                $collection['itemsNext'] = $itemsNext;
            }
        }
        
        return $collection;
    }
    
    private function getCollectionMarks($id)
    {
        $person_id = AuthComponent::user('User.person_id');
        if (SessionComponent::check('Collection.params.pass.0')) {
            $person_id = SessionComponent::read('Collection.params.pass.0');
        }
        
        $items = $this->Mark->find('all', array(
            'conditions' => array(
                'Mark.person_id' => $person_id
            ),
            'order' => array('Mark.created DESC'),
            'contain' => array(
                'Item' => array(
                    'fields' => array('id', 'thumbs_50x50', 'publish')
                )
            )
        ));
        
        //Поиск текущего медиафайла
        $currentItemPosition = '';
        foreach($items as $key => $item) {
            if ($item['Item']['id'] == $id) {
                $currentItemPosition = $key;
                break;
            }
        }
        
        $collection = array('itemsPrev', 'itemsNext');
        
        if ($currentItemPosition !== '') {
            //Предыдущие медиафайлы относительно выбранного
            $itemsPrev = array();
            for ($i = ($currentItemPosition - 1); $i >= 0; $i--) {
                if ($items[$i]['Item']['publish']) {
                    $itemsPrev[]['Item'] = $items[$i]['Item'];

                    if (count($itemsPrev) == 3) {
                        break;
                    }
                }
            }
            
            if (!empty($itemsPrev)) {
                $collection['itemsPrev'] = array_reverse($itemsPrev);
            }
            
            //Следующие медиафайлы
            $itemsNext = array();
            for ($i = ($currentItemPosition + 1); $i < count($items); $i++) {
                if ($items[$i]['Item']['publish']) {
                    $itemsNext[]['Item'] = $items[$i]['Item'];

                    if (count($itemsNext) == 3) {
                        break;
                    }
                }
            }
            
            if (!empty($itemsNext)) {
                $collection['itemsNext'] = $itemsNext;
            }
        }
        
        return $collection;
    }
    

    
    private function getCollectionUploads($item)
    {
        $conditions = array('Item.user_id' => AuthComponent::user('User.id'));
        $collection = $this->getCollection($conditions, $item['Item']['id']);
        
        return $collection;
    }
    
    private function getCollectionItemsNew($item)
    {
        $collection = '';
        if (!$item['Item']['verification']) {
            $conditions = array('Item.verification' => false);
            $collection = $this->getCollection($conditions, $item['Item']['id']);
        }
        
        return $collection;
    }
    
    private function getCollectionItemsNotPublished($item)
    {
        $collection = '';
        if (!$item['Item']['publish']) {
            $conditions = array('Item.publish' => false);
            $collection = $this->getCollection($conditions, $item['Item']['id']);
        }
        
        return $collection;
    }
    
    private function getCollectionItemsPublished($item)
    {
        $collection = '';
        if ($item['Item']['publish']) {
            $conditions = array('Item.publish' => true);
            $collection = $this->getCollection($conditions, $item['Item']['id']);
        }
        
        return $collection;
    }
    
    private function getCollectionItemsWithoutAlbum($item)
    {
        $collection = '';
        if ($item['Item']['publish'] && empty($item['Item']['album_id'])) {
            $conditions = array(
                'Item.publish' => true,
                'Item.album_id' => null
            );
            $collection = $this->getCollection($conditions, $item['Item']['id']);
        }
        
        return $collection;
    }
    
    private function getCollectionItemsWithoutDescription($item)
    {
        $collection = '';
        if ($item['Item']['publish'] && 
            empty($item['Item']['title']) &&
            empty($item['Item']['description']) &&
            empty($item['Item']['start_year']) &&
            empty($item['Item']['end_year'])
        ) {
            $conditions = array(
                'Item.publish' => true,
                'Item.title' => null,
                'Item.description' => null,
                'Item.start_year' => null,
                'Item.end_year' => null
            );
            
            $collection = $this->getCollection($conditions, $item['Item']['id']);
        }
        
        return $collection;
    }
    
    //Функция проверки соответствия проверяемой коллекции с записью в сессии
    // Функция относится только к редактируемым коллекциям (те, что расположены в админке)
    private function collectionEditCheck($param)
    {
        $result = false;
        if (SessionComponent::check('Collection')) {
            $collection_session = SessionComponent::read('Collection');
            
            if ($collection_session['params']['controller'] == 'items' &&
                $collection_session['params']['action'] == 'admin_index' &&
                $collection_session['params']['param'] == $param
            ) {
                $result = true;
            }
        }
        
        return $result;
    }
    
    private function collectionAlbumAddEditCheck()
    {
        $result = false;
        $collection_session = SessionComponent::read('Collection');
        
        if ($collection_session['params']['controller'] == 'albums' &&
            ($collection_session['params']['action'] == 'admin_add' ||
             $collection_session['params']['action'] == 'admin_edit'
            )
        ) {
            $result = true;
        }
        
        return $result;
    }
    
    private function collectionBookmarksCheck()
    {
        $result = false;
        $collection_session = SessionComponent::read('Collection');
        
        if ($collection_session['params']['controller'] == 'bookmarks' &&
            $collection_session['params']['action'] == 'index'
        ) {
            $result = true;
        }
        
        return $result;
    }
    
    private function collectionMarksCheck()
    {
        $result = false;
        $collection_session = SessionComponent::read('Collection');
        
        if ($collection_session['params']['controller'] == 'marks' &&
            $collection_session['params']['action'] == 'index'
        ) {
            $result = true;
        }
        
        return $result;
    }
    
    private function collectionUploadsCheck()
    {
        $result = false;
        $collection_session = SessionComponent::read('Collection');
        
        if ($collection_session['params']['controller'] == 'items' &&
            $collection_session['params']['action'] == 'uploads'
        ) {
            $result = true;
        }
        
        return $result;
    }
    
    private function collectionMediaCheck()
    {
        $result = false;
        $collection_session = SessionComponent::read('Collection');
        
        if ($collection_session['params']['controller'] == 'items' &&
            $collection_session['params']['action'] == 'index'
        ) {
            $result = true;
        }
        
        return $result;
    }
}
