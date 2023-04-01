<?php
App::uses('AppController', 'Controller');

/**
 * Comments Controller
 *
 * @property Comment $Comment
 * @property PaginatorComponent $Paginator
 */
class CommentsController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if (
            !$this->request->is('ajax') || 
            !$this->request->is('post') ||
            !isset($this->params['pass'][0])
        ) {
            throw new BadRequestException();
        }

        $comment = '';
        $item = $this->Comment->Item->find('first', array(
            'conditions' => array(
                'Item.id' => $this->params['pass'][0],
                'Item.publish' => true
            ),
            'contain' => array(
                'Comment' => array('fields' => array('id')),
            )
        ));

        if (
            !empty($item) && 
            isset($this->request->data['body']) && 
            !empty($this->request->data['body'])
        ) {
            $data['Comment']['user_id'] = $this->Session->read('Auth.User.User.id');
            $data['Comment']['item_id'] = $this->params['pass'][0];
            $data['Comment']['body'] = $this->request->data['body'];
            
            if (isset($this->request->data['parent_id'])) {
                foreach($item['Comment'] as $comment) {
                    if ($comment['id'] == $this->request->data['parent_id']) {
                        $data['Comment']['parent_id'] = $this->request->data['parent_id'];
                        break;
                    }
                }
            }
            
            $this->Comment->create();
            if ($this->Comment->save($data)) {
                $comment = $this->Comment->find(
                    'first',
                    array(
                        'conditions' => array(
                            'Comment.id' => $this->Comment->getLastInsertId()
                        ),
                        'contain' => array(
                            'User' => 'Person'
                        )
                    )
                );
            }
        }

        $this->set('comment', $comment);
    }
    
    public function admin_index()
    {
        
    }
}
