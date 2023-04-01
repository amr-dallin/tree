<?php
App::uses('AppModel', 'Model');

/**
 * Album Model
 *
 * @property Item $Item
 */
class Album extends AppModel
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'title' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'album_id',
            'dependent' => false,
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
        if (empty($this->data['Album']['start_year'])) {
            unset($this->data['Album']['start_year']);
        }
        
        if (empty($this->data['Album']['end_year'])) {
            unset($this->data['Album']['end_year']);
        }
        
        return $this->data;
    }
    
    public function getAlbums($conditions = '')
    {
        return $this->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'Item' => array(
                    'conditions' => array(
                        'publish' => true
                    )
                )
            )
        ));
    }
    
    public function getAlbumsSearch($query)
    {
        $conditions = array(
            'Album.title LIKE' => '%' . $query['q'] . '%s',
            'Album.start_year'
        );
        return $this->getAlbums($conditions);
    }
    
}
