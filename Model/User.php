<?php
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Group $Group
 * @property Comment $Comment
 * @property Item $Item
 * @property Person $Person
 */
class User extends AppModel
{
    public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false));

    public function __construct()
    {
        parent::__construct();

        $this->validate = array(
            'username' => array(
                'between' => array(
                    'rule' => array('between', 5, 20),
                    'message' => __('The number of characters must be in the range of 5 to 20'),
                    'allowEmpty' => false,
                    'required' => 'create',
                    'last' => true
                ),
                'regex' => array(
                    'rule' => array('custom', '/^[a-z0-9\._]{5,20}$/i'),
                    'message' => __('It is necessary to use only Latin letters, numbers, dot and underscore characters'),
                    'allowEmpty' => false,
                    'required' => 'create',
                    'last' => true
                ),
                'isUnique' => array(
                    'rule' => array('isUnique'),
                    'message' => __('Username already in use'),
                    'allowEmpty' => false,
                    'required' => true,
                    'on' => 'create',
                    'last' => true
                ),
                'isUniqueUsername' => array(
                    'rule' => 'isUniqueUsername',
                    'message' => __('Username already in use'),
                    'allowEmpty' => false,
                    'required' => false,
                    'on' => 'update'
                )
            ),
            'email' => array(
                'email' => array(
                    'rule' => array('email'),
                    'message' => __('Email address not valid'),
                    'allowEmpty' => true,
                    'required' => false,
                    'last' => true
                ),
                'isUnique' => array(
                    'rule' => array('isUnique'),
                    'message' => __('Email already in use'),
                    'allowEmpty' => true,
                    'required' => false,
                    'on' => 'create',
                    'last' => true
                ),
                'isUniqueEmail' => array(
                    'rule' => 'isUniqueEmail',
                    'message' => __('Email already in use'),
                    'allowEmpty' => true,
                    'required' => false,
                    'on' => 'update'
                )
            ),
            'password' => array(
                'betweenCreate' => array(
                    'rule' => array('between', 6, 20),
                    'message' => __('The number of characters must be in the range of 6 to 20'),
                    'allowEmpty' => false,
                    'required' => true,
                    'on' => 'create',
                    'last' => true
                ),
                'betweenUpdate' => array(
                    'rule' => array('between', 6, 20),
                    'message' => __('The number of characters must be in the range of 6 to 20'),
                    'allowEmpty' => true,
                    'required' => false,
                    'on' => 'update',
                    'last' => true
                ),
                'regexCreate' => array(
                    'rule' => array('custom', '/^[A-Za-z0-9_-]{6,20}$/i'),
                    'message' => __('Use latin letters, numbers and underscores'),
                    'allowEmpty' => false,
                    'required' => true,
                    'last' => true
                ),
                'regexUpdate' => array(
                    'rule' => array('custom', '/^[A-Za-z0-9_-]{6,20}$/i'),
                    'message' => __('Use latin letters, numbers and underscores'),
                    'allowEmpty' => true,
                    'required' => false,
                    'last' => true
                ),
                'regex2Create' => array(
                    'rule' => 'validatePasswordConfirm',
                    'message' => __('Re-entered password does not match'),
                    'allowEmpty' => false,
                    'required' => true,
                    'on' => 'create'
                ),
                'regex2Update' => array(
                    'rule' => 'validatePasswordConfirm',
                    'message' => __('Re-entered password does not match'),
                    'allowEmpty' => true,
                    'required' => false,
                    'on' => 'update'
                )
            )
        );
    }
    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'person_id',
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
            'foreignKey' => 'user_id',
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
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'user_id',
            'dependent' => false,
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
            'foreignKey' => 'user_id',
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

    public function parentNode()
    {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        }
        return array('Group' => array('id' => $groupId));
    }

    public function bindNode($user)
    {
        
        return array(
            'model' => 'Group', 
            'foreign_key' => $user['User']['User']['group_id']
        );
    }


    public function beforeSave($options = array())
    {   
        if (
            isset($this->data[$this->alias]['password']) && 
            !empty($this->data[$this->alias]['password'])
        ) {
            $this->data['User']['password'] = 
                AuthComponent::password($this->data['User']['password']);
        } else {
            unset($this->data[$this->alias]['password']);
        }
        
        if (
            isset($this->data[$this->alias]['email']) && 
            empty($this->data[$this->alias]['email'])
        ) {
            unset($this->data[$this->alias]['email']);
        }

        return true;
    }

    /**
     * login method
     *
     * @param array $data
     * @return array
     */
    
    public function loginData($data)
    {
        $conditions = array(
            'User.username' => $data[$this->alias]['username'],
            'User.password' => AuthComponent::password($data[$this->alias]['password'])
        );
        
        return $this->login($conditions);
    }
    
    public function loginAuth()
    {
        $conditions = array(
            'User.id' => AuthComponent::user('User.id')
        );
        
        return $this->login($conditions);
    }
    
    public function loginDirect($token)
    {
        $conditions = array(
            'MD5(CONCAT(User.id, User.created))' => $token
        );
        
        return $this->login($conditions);
    }
    
    private function login($conditions)
    {
        return $this->find(
            'first',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'User.id',
                    'User.group_id',
                    'User.person_id',
                    'User.username',
                    'User.full_name',
                    'User.thumbs_50x50',
                    'User.thumbs_120x120',
                    'Person.last_name',
                    'Person.first_name',
                    'Person.second_name',
                    'Person.gender',
                    'Person.thumbs_50x50',
                    'Person.thumbs_120x120'
                ),
                'contain' => array('Person')
            )
        );
    }
    
    private function generatePassword($length = 10)
    {
        $password = '';
        $i = 0;
        $possible = '0123456789QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm-_';

        while ($i < $length) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }
        
        return $password;
    }

    public function validatePasswordConfirm()
    {
        $result = false;
        if ($this->data[$this->alias]['password'] == $this->data[$this->alias]['confirm_password']) {
            $result = true;
        }
        
        return $result;
    }

    public function isUniqueEmail()
    {
        $result = false;
        
        $user = $this->find(
            'first',
            array(
                'conditions' => array(
                    'User.email' => $this->data[$this->alias]['email']
                )
            )
        );
        if (
            empty($user) ||
            ($this->id == $user[$this->alias]['id'])
        ) {
            $result = true;
        }

        return $result;
    }
    
    public function isUniqueUsername()
    {
        $result = false;
        
        $user = $this->find(
            'first',
            array(
                'conditions' => array(
                    'User.username' => $this->data[$this->alias]['username']
                )
            )
        );
        if (
            empty($user) ||
            ($this->id == $user[$this->alias]['id'])
        ) {
            $result = true;
        }

        return $result;
    }
}
