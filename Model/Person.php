<?php
App::uses('AppModel', 'Model');

/**
 * Person Model
 *
 * @property User $User
 * @property Father $Father
 * @property Mother $Mother
 */
class Person extends AppModel
{

    public $virtualFields = array(
        'full_name' => 'IF(Person.second_name IS NULL OR Person.second_name = "", CONCAT(Person.last_name, " ", Person.first_name), CONCAT(Person.last_name, " ", Person.first_name, " ", Person.second_name))',
        'short_name' => 'CONCAT(Person.first_name, " ", Person.last_name)'
    );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);

        $this->validate = array(
            'last_name' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => __('You must enter a last name'),
                    'allowEmpty' => false,
                    'required' => 'create'
                )
            ),
            'first_name' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => __('You must enter a first name'),
                    'allowEmpty' => false,
                    'required' => 'create'
                )
            ),
            'gender' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => __('Gender must be specified'),
                    'allowEmpty' => false,
                    'required' => 'create'
                )
            ),
            'birthday' => array(
                'validate' => array(
                    'rule' => array('date', 'ymd'),
                    'message' => __('Incorrect date of birth'),
                    'allowEmpty' => true,
                    'required' => false
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
        'Father' => array(
            'className' => 'Person',
            'foreignKey' => 'father_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Mother' => array(
            'className' => 'Person',
            'foreignKey' => 'mother_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Spouse' => array(
            'className' => 'Person',
            'foreignKey' => 'spouse_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasOne = array(
        'User' => array(
            'className' => 'User',
            'dependent' => true
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Mark' => array(
            'className' => 'Mark',
            'foreignKey' => 'person_id',
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

    public function beforeValidate($options = array())
    {
        if (
            isset($this->data[$this->alias]['birthday']) &&
            !empty($this->data[$this->alias]['birthday']) &&
            !empty(CakeTime::format($this->data[$this->alias]['birthday'], '%Y-%d-%m'))
        ) {
            $this->data[$this->alias]['birthday'] = CakeTime::format($this->data[$this->alias]['birthday'], '%Y-%d-%m');
        }

        return true;
    }

    public function beforeSave($options = array())
    {
        
    }

    public function getPeople()
    {
        return $this->find(
                'all', array(
                'fields' => array(
                    'id',
                    'father_id',
                    'mother_id',
                    'spouse_id',
                    'short_name',
                    'gender'
                ),
                'contain' => array('Mark')
                )
        );
    }

    public function getPerson($id)
    {
        return $this->find(
                'first', array(
                'conditions' => array(
                    'Person.id' => $id
                ),
                'contain' => false
                )
        );
    }

    public function getFamily($person_id)
    {
        $person = $this->find(
            'first', array(
            'conditions' => array(
                'Person.id' => $person_id
            ),
            'contain' => array(
                'Father' => array('Mark'),
                'Mother' => array('Mark'),
                'Spouse' => array('Mark'),
                'Mark'
            )
            )
        );

        $family = array();
        if (!empty($person)) {
            $family[] = array(
                'Person' => $person['Person'],
                'Mark' => $person['Mark']
            );

            $fatherConditions = '';
            if (!empty($person['Father']['id'])) {
                $short_name = $person['Father']['first_name'] . ' ' . $person['Father']['last_name'];
                $person['Father']['short_name'] = $short_name;
                $family[] = array(
                    'Person' => $person['Father'],
                    'Mark' => $person['Father']['Mark']
                );
                $fatherConditions = array('Person.father_id' => $person['Person']['father_id']);
            }

            $motherConditions = '';
            if (!empty($person['Mother']['id'])) {
                $short_name = $person['Mother']['first_name'] . ' ' . $person['Mother']['last_name'];
                $person['Mother']['short_name'] = $short_name;
                $family[] = array(
                    'Person' => $person['Mother'],
                    'Mark' => $person['Mother']['Mark']
                );
                $motherConditions = array('Person.mother_id' => $person['Person']['mother_id']);
            }

            if (!empty($person['Spouse']['id'])) {
                $short_name = $person['Spouse']['first_name'] . ' ' . $person['Spouse']['last_name'];
                $person['Spouse']['short_name'] = $short_name;
                $family[] = array(
                    'Person' => $person['Spouse'],
                    'Mark' => $person['Spouse']['Mark']
                );
            }

            if (!empty($fatherConditions) && !empty($motherConditions)) {
                $brothers_sisters = $this->find(
                    'all', array(
                    'conditions' => array(
                        $fatherConditions,
                        $motherConditions,
                        'Person.id !=' => $person['Person']['id']
                    ),
                    'contain' => array('Mark')
                    )
                );

                if (!empty($brothers_sisters)) {
                    foreach ($brothers_sisters as $bs) {
                        $family[] = array(
                            'Person' => $bs['Person'],
                            'Mark' => $bs['Mark']
                        );
                    }
                }
            }

            $childrenConditions = array();
            switch ($person['Person']['gender']) {
                case 1:
                    $childrenConditions = array('Person.father_id' => $person['Person']['id']);
                    break;
                case 2:
                    $childrenConditions = array('Person.mother_id' => $person['Person']['id']);
                    break;
            }

            $children = $this->find(
                'all', array(
                'conditions' => array(
                    $childrenConditions
                ),
                'contain' => array(
                    'Mark'
                )
                )
            );

            if (!empty($children)) {
                foreach ($children as $child) {
                    $family[] = array(
                        'Person' => $child['Person'],
                        'Mark' => $child['Mark']
                    );
                }
            }
        }

        return $family;
    }
}
