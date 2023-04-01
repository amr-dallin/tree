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
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper
{
    var $helpers = array('Html', 'Form', 'Session', 'Time');

    public function titleForLayout($title = null)
    {
        return $title;
    }
    
    public function dateFormat($format, $date)
    {
        if (!empty($date) && !empty($format)) {
            return $this->Time->format($format, $date);
        } else {
            return false;
        }
    }

    public function loggedIn()
    {
        if ($this->Session->check('Auth.User.User')) {
            return true;
        }
        
        return false;
    }

    public function loggedInUserGroup($groups)
    {
        $result = false;
        
        $type = gettype($groups);
        switch($type) {
            case 'integer':
                if ($this->Session->read('Auth.User.User.group_id') == $groups) {
                    $result = true;
                }
                break;
            case 'array':
                $result = in_array($this->Session->read('Auth.User.User.group_id'), $groups);
                break;
        }
        
        return $result;
    }

    public function avatarPath($type, $user = null)
    {
        $path = '';
        if (!empty($user)) {
            $path = $user['Person']['thumbs_' . $type];
            $gender = $user['Person']['gender'];
        } else {
            $path = $this->Session->read('Auth.User.Person.thumbs_' . $type);
            $gender = $this->Session->read('Auth.User.Person.gender');
        }
        
        if (empty($path)) {
            switch ($gender) {
                case 1:
                    $path = $this->webroot . 'img' . DS . 'man_' . $type . '.jpg';
                    break;
                case 2:
                    $path = $this->webroot . 'img' . DS . 'woman_' . $type . '.jpg';
                    break;
            }
        }
        
        return $path;
    }
    
    public function people($people)
    {
        $data = array();
        foreach($people as $person) {
            $parents = array();
            if (!empty($person['Person']['father_id'])) {
                $parents[] = $person['Person']['father_id'];
            }
            
            if (!empty($person['Person']['mother_id'])) {
                $parents[] = $person['Person']['mother_id'];
            }
            
            $short_name = $person['Person']['short_name'];
            $short_name_href = $this->url(
                array(
                    'controller' => 'people',
                    'action' => 'view',
                    $person['Person']['id']
                )
            );
            $quantity_marks_href = $this->url(
                array(
                    'controller' => 'marks',
                    'action' => 'index',
                    $person['Person']['id']
                )
            );
            if ($person['Person']['id'] == $this->Session->read('Auth.User.User.person_id')) {
                $short_name = __('I');
                $short_name_href = $this->url(
                    array(
                        'controller' => 'people',
                        'action' => 'edit'
                    )
                );
                
                $quantity_marks_href = $this->url(
                    array(
                        'controller' => 'marks',
                        'action' => 'index'
                    )
                );
            }
            
            switch($person['Person']['gender']) {
                case 1:
                    $avatar = DS . 'img' . DS . 'man_50x50.jpg';
                    break;
                case 2:
                    $avatar = DS . 'img' . DS . 'woman_50x50.jpg';
                    break;
            }
            
            $spouses = array();
            if (!empty($person['Person']['spouse_id'])) {
                $spouses = array($person['Person']['spouse_id']);
            }
            
            $data[] = array(
                'id' => $person['Person']['id'],
                'parents' => $parents,
                'spouses' => $spouses,
                'avatar' => $avatar,
                'quantity_marks' => count($person['Mark']) . ' ' . __('Marks'),
                'quantity_marks_href' => $quantity_marks_href,
                'short_name' => $short_name,
                'short_name_href' => $short_name_href,
            );
        }
        
        return json_encode($data);
    }
    
}
