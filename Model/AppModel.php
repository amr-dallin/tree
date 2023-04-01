<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model
{
    var $actsAs = array('Containable');
    
    public function collectionSession()
    {
        SessionComponent::write(
            'Collection', array(
                'params' => Router::getRequest()->params,
                'query' => Router::getRequest()->query
            )
        );
    }
    
    public function collectionDefaultSession()
    {
        SessionComponent::write(
            'Collection', array(
                'params' => array(
                    'controller' => 'items',
                    'action' => 'index'
                )
            )
        );
    }
}
