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
App::uses('AppHelper', 'View/Helper');


class ItemHelper extends AppHelper
{
    var $helpers = array('Html', 'Form', 'Session', 'Collection');
    
    public function titleParam($param = null)
    {
        $title = '';
        
        switch($param) {
            case '':
                $title = __('Media files');
                break;
            case 'new':
                $title = __('Unverified media files');
                break;
            case 'notpublished':
                $title = __('Not published media files');
                break;
            case 'published':
                $title = __('Published media files');
                break;
        }
        
        return $title;
    }
    
    public function navigationParam($param = null)
    {
        $menu = array();
        
        switch($param) {
            case 'new':
                $menu = array(1 => true);
                break;
            case 'notpublished':
                $menu = array(2 => true);
                break;
        }
        
        return $menu;
    }
    
    public function description($item)
    {
        $description = '';
        
        if (!empty($item['Item']['title'])) {
            $description .= $this->Html->tag('h1',
                $item['Item']['title'], array('class' => 'margin-top-0')
            );
        }
        
        if (!empty($item['Item']['album_id'])) {
            $description .= $this->Html->div(
                'album-link',
                __('Album: %s', 
                    $this->Html->link(
                        $item['Album']['title'],
                        array(
                            'controller' => 'albums', 
                            'action' => 'view', 
                            $item['Item']['album_id'], 
                            'admin' => false
                        ),
                        array('title' => __('Album: %s', $item['Album']['title']))
                    )
                )
            );
        }
        
        if (
            !empty($item['Item']['start_year']) && 
            empty($item['Item']['end_year'])
        ) {
            $description .= $this->Html->div('date-taken',
                __('Date of issue: not earlier than %s', $item['Item']['start_year'])
            );
        } elseif(empty($item['Item']['start_year']) && 
            !empty($item['Item']['end_year'])
        ) {
            $description .= $this->Html->div('date-taken',
                __('Date of issue: not later than %s', $item['Item']['end_year'])
            );
        } elseif(!empty($item['Item']['start_year']) && 
            !empty($item['Item']['end_year'])
        ) {
            $description .= $this->Html->div('date-taken',
                __('Date of issue: between %s and %s', 
                    $item['Item']['start_year'], 
                    $item['Item']['end_year']
                )
            );
        }
        
        if (!empty($item['Item']['description'])) {
            $description .= $this->Html->div('description', $item['Item']['description']);
        }
        
        if (empty($description)) {
            $description .= $this->Html->div(
                'text-empty',
                __('There are no descriptions for this media file yet. But you can contribute to the story.')
            );
        }
        
        return $description;
    }
    
    private function photoViewerPath($item)
    {
        $path = '';
        for ($i = 5; $i > 0; $i--) {
            foreach($item['Photo'] as $k => $photo) {
                if ($photo['scale'] == $i) {
                    $path = $item['Photo'][$k]['path'];
                    break(2);
                }
            }
        }
        
        return $path;
    }
    
    public function photoViewerAdmin($item)
    {
        return $this->Html->image(
            ITEM . $this->photoViewerPath($item),
            array(
                'class' => 'img-responsive',
                'style' => 'max-height: 400px; margin: 0 auto;'
            )
        );
    }
    
    public function mode($item)
    {
        $verification = '';
        if (!$item['Item']['verification']) {
            $verification = $this->Form->postLink(
                $this->Html->tag('i', '', array('class' => 'fa fa-font')) . 
                ' ' . __('Verified'), 
                array(
                    'controller' => 'items', 
                    'action' => 'verification', 
                    h($item['Item']['id']),
                    'admin' => true
                ), 
                array(
                    'escape' => false,
                    'class' => 'btn btn-primary btn-xs btn-block',
                    'confirm' => __('Is the media check complete?'),
                    'title' => __('Verified')
                )
            );
        }
        
        
        $publishUrl = array(
            'controller' => 'items', 
            'action' => 'publish', 
            h($item['Item']['id']),
            'admin' => true
        );
        if ($item['Item']['publish']) {
            $publish = $this->Form->postLink(
                $this->Html->tag('i', '', array('class' => 'fa fa-times')) . 
                ' ' . __('Remove'), 
                $publishUrl, 
                array(
                    'title' => __('Remove from publication'),
                    'class' => 'btn btn-warning btn-xs btn-block',
                    'confirm' => __('Are you sure you want to remove the media from the publication?'),
                    'escape' => false
                )
            );
        } else {
            $publish = $this->Form->postLink(
                $this->Html->tag('i', '', array('class' => 'fa fa-times')) . 
                ' ' . __('Publish'),
                $publishUrl, 
                array(
                    'title' => __('Publish'),
                    'class' => 'btn btn-success btn-xs btn-block',
                    'confirm' => __('Are you sure you want to publish the media?'),
                    'escape' => false
                )
            );
        }

        $delete = $this->Form->postLink(
                $this->Html->tag('i', '', array('class' => 'fa fa-trash')) . 
                ' ' . __('Delete'),
            array(
                'controller' => 'items',
                'action' => 'delete',
                h($item['Item']['id']),
                'admin' => true
            ),
            array(
                'class' => 'btn btn-danger btn-xs btn-block',
                'confirm' => 'Are you sure you want to delete the media?',
                'escape' => false,
                'title' => __('Delete')
            )
        );
        
        return $verification . $publish . $delete;
    }
    
    public function items($items, $options = array())
    {
        $textEmptyStatus = 'display: block;';
        $items_data = '';
        $data_quantity = '';
        if (!empty($items)) {
            foreach ($items as $item) {
                $items_data .= $this->item($item, $options);
            }
            $data_quantity = count($items);
            
            $textEmptyStatus = 'display: none;';
        }
        
        $textEmpty = __('No content');
        if (isset($options['textEmpty']) && !empty($options['textEmpty'])) {
            $textEmpty = $options['textEmpty'];
        }
        
        return 
            $this->Html->div('items', $items_data) .
            $this->Html->div('quantity-hidden-block', '', array(
                'id' => 'quantity', 'data-quantity' => $data_quantity
            )) . 
            $this->Html->div('text-empty', $textEmpty, array('style' => $textEmptyStatus));
    }
    
    public function item($item, $options = array())
    {
        $image = $this->Html->image(
            ITEM . $item['Photo'][0]['path'], 
            array(
                'alt'    => $item['Item']['title'],
                'width'  => $item['Photo'][0]['width'],
                'height' => $item['Photo'][0]['height']
            )
        );
        
        if (!in_array('without_link', $options)) {
            $url = array(
                'controller' => 'items',
                'action' => 'view',
                $item['Item']['id'],
                'admin' => false
            );

            if (in_array('edit_link', $options)) {
                $url = array(
                    'controller' => 'items',
                    'action' => 'edit',
                    $item['Item']['id'],
                    'admin' => true
                );
            }
            
            $image = $this->Html->link(
                $image,
                $url, 
                array(
                    'title' => $item['Item']['title'] . ' ',
                    'escape' => false
                )
            );
        }
        
        $checkbox = '';
        if (in_array('checkbox', $options)) {
            $checkbox = $this->Form->input(
                'Item.' . $item['Item']['id'] . '.id',
                array(
                    'div' => false,
                    'label' => false,
                    'type' => 'checkbox',
                    'value' => $item['Item']['id'],
                    'hiddenField' => false,
                    'before' => '<label for="Item' . $item['Item']['id'] . 'Id">',
                    'after' => '</label>'
                )
            );
        }
        
        $bookmark = '';
        if (in_array('bookmark', $options)) {
            $bookmark_active = '';
            $bookmark_title = __('Add to bookmarks');
            if (!empty($item['Bookmark'])) {
                $bookmark_active = 'active';
                $bookmark_title = __('Remove from bookmarks');
            }
            $bookmark = $this->Html->div('bookmark ' . $bookmark_active, 
                $this->Html->tag('i', '', array('class' => 'fa fa-bookmark')),
                array('title' => $bookmark_title)
            );
        }
        
        $trash = '';
        if (in_array('trash', $options)) {
            $trash = $this->Html->div('trash', 
                $this->Html->tag('i', '', array('class' => 'fa fa-trash')),
                array('title' => '')
            );
        }
        
        $top_desc = $this->Html->div('top-desc', $trash . $bookmark);
        
        
        $title_div = $this->Html->div('title', $item['Item']['title'] . ' ');
        $quantity_comment = '';
        if (count($item['Comment']) > 0) {
            $quantity_comment = count($item['Comment']) . ' ';
        }
        
        $comment_div = 
            $this->Html->div('comment', $quantity_comment . 
            $this->Html->tag('i', '', array('class' => 'fa fa-comment')));
        
        $bottom_desc = $this->Html->div('bottom-desc', $title_div . $comment_div);
        
        
        return $this->Html->div(
            'item',
            $image . $checkbox . $top_desc . $bottom_desc,
            array('id' => $item['Item']['id'])
        );
    }
    
    
    public function itemsPrevious($items)
    {
        $options = array();
        $data = '';
        if ($this->Collection->collectionAlbumAddEditCheck()) {
            $options = array('checkbox', 'without_link');
        }
        
        if ($this->Collection->collectionEditCheck()) {
            $options = array('edit_link', 'trash');
        }
        
        if ($this->Collection->collectionMediaCheck()) {
            $options = array('bookmark');
        }
        
        if ($this->Collection->collectionAlbumCheck()) {
            $options = array('bookmark', 'trash');
        }
        
        foreach($items as $item) {
            $data .= $this->item($item, $options);
        }
        
        return $data;
    }
    
    public function albums($albums)
    {
        $albums_data = '';
        $display = true;
        foreach($albums as $key => $album) {
            if ($key > 3) {
                $display = false;
            }
            
            $albums_data .= $this->album($album, $display);
        }
        
            $more = '';
        if (count($albums) > 4) {
            $more = $this->Html->div('more', __('Show all %s albums', count($albums)));
        }

        return $this->Html->div('row', $albums_data) . $more;
    }
    
    public function album($album, $display = true)
    {
        $title_div = $this->Html->div('title', '' . $album['Album']['title']);
        $quantity_div = $this->Html->div('quantity', __('%s Mediafiles', count($album['Item'])));
        
        $bottom_desc = $this->Html->div('bottom-desc', $title_div . $quantity_div);
        
        
        $object = $this->Html->div(
            'empty-album', $this->Html->tag('i', '', array('class' => 'fa fa-camera'))
        );
        
        if (!empty($album['Item'])) {
            
            $rand = array_rand($album['Item']);
            
            if (file_exists(ITEMS . DS . $album['Item'][$rand]['thumbs_263x180'])) {
                $object = $this->Html->image(
                    ITEM . $album['Item'][$rand]['thumbs_263x180'], array(
                    'alt' => $album['Album']['title'],
                    )
                );
            }
        }

        
        $link = $this->Html->link(
            $object . $bottom_desc, array(
                'controller' => 'albums',
                'action' => 'view',
                $album['Album']['id'],
                'admin' => false
            ), array(
                'title' => '' . $album['Album']['title'],
                'escape' => false
            )
        );
        
        $album_div = $this->Html->div('album', $link);
        
        $style = 'display: block;';
        if (!$display) {
            $style = 'display: none;';
        }
        
        return $this->Html->div(
            'col-xs-12 col-sm-6 col-md-3',
            $album_div,
            array('style' => $style)
        );
    }
    
    
    public function linkBackCollection($album_page = false)
    {
        $title = __('Back to media');
        $url = array(
            'controller' => 'items',
            'action' => 'index',
            'admin' => false,
        );
        
        if ($this->Session->check('Collection')) {
            $data = $this->linkBackCollectionData($album_page);
            
            if (!empty($data)) {
                $title = $data[0];
                $url = $data[1];
            }
        }
        
        return $this->Html->link(
            $this->Html->tag('i', '', array(
                'class' => 'fa fa-long-arrow-left')
            ) . $title, 
            $url,
            array('escape' => false)
        );
    }
    
    private function linkBackCollectionData($album_page)
    {
        $data = array();    
        
        if ($this->Collection->collectionMediaCheck()) {
            if (!empty($this->Collection->album_id) && !$album_page) {
                $data = array(
                    __('Back to album'),
                    array(
                        'controller' => 'albums',
                        'action' => 'view',
                        $this->Collection->album_id,
                        '?' => $this->Collection->query,
                        'admin' => false
                    )
                );
            } else {
                $data = array(
                    __('Back to media'),
                    array(
                        'controller' => 'items',
                        'action' => 'index',
                        '?' => $this->Collection->query,
                        'admin' => false
                    )
                );
            }
        } 
        
        if ($this->Collection->collectionBookmarksCheck()) {
            $data[] = __('Back to bookmarks');
            $data[] = array(
                'controller' => 'bookmarks',
                'action' => 'index',
                '?' => $this->Collection->query,
                'admin' => false
            );
        }
        
        if ($this->Collection->collectionMarksCheck()) {
            $data[] = __('Back to marks');
            $data[] = array(
                'controller' => 'marks',
                'action' => 'index',
                $this->Collection->pass,
                '?' => $this->Collection->query,
                'admin' => false
            );
        }
        
        if ($this->Collection->collectionUploadsCheck()) {
            $data[] = __('Back to uploads');
            $data[] = array(
                'controller' => 'items',
                'action' => 'uploads',
                '?' => $this->Collection->query,
                'admin' => false
            );
        }
        
        if ($this->Collection->collectionEditCheck('new')) {
            $data[] = __('Back to new media');
            $data[] = array(
                'controller' => 'items',
                'action' => 'index',
                'admin' => true,
                '?' => $this->Collection->query,
                'param' => 'new'
            );
        }
        
        if ($this->Collection->collectionEditCheck('not_published')) {
            $data[] = __('Back to unpublished media');
            $data[] = array(
                'controller' => 'items',
                'action' => 'index',
                'admin' => true,
                '?' => $this->Collection->query,
                'param' => 'not_published'
            );
        }
        
        if ($this->Collection->collectionEditCheck('published')) {
            $data[] = __('Back to published media');
            $data[] = array(
                'controller' => 'items',
                'action' => 'index',
                'admin' => true,
                '?' => $this->Collection->query,
                'param' => 'published'
            );
        }
        
        if ($this->Collection->collectionEditCheck('without_album')) {
            $data[] = __('Back to media without albums');
            $data[] = array(
                'controller' => 'items',
                'action' => 'index',
                'admin' => true,
                '?' => $this->Collection->query,
                'param' => 'without_album'
            );
        }
        
        if ($this->Collection->collectionEditCheck('without_description')) {
            $data[] = __('Back to media without description');
            $data[] = array(
                'controller' => 'items',
                'action' => 'index',
                'admin' => true,
                '?' => $this->Collection->query,
                'param' => 'without_description'
            );
        }
        
        return $data;
    }
    
    public function viewerImage($item)
    {
        $path = '';
        foreach($item['Photo'] as $photo) {
            if ($photo['scale'] == 3) { //Image with height = 400px
                $path = $photo['path'];
                $width = $photo['width'];
                $height = $photo['height'];
                break;
            }
        }
        
        return $this->Html->image(ITEM . $path, array('data-width' => $width, 'data-height' => $height));
    }
    
    public function bookmarkLink($item, $quantity = false)
    {
        $active = '';
        $title = __('Add to bookmarks');
        foreach($item['Bookmark'] as $bookmark) {
            if ($bookmark['user_id'] == $this->Session->check('Auth.User.User.id')) {
                $active = 'active';
                $title = __('Remove from bookmarks');
                break;
            }
        }
        
        $icon_size = 'fa-lg';
        if ($quantity) {
            $quantity = $this->Html->tag('span', 
                count($item['Bookmark']), 
                array('id' => 'bookmark-quantity')
            ) . ' ';
            $icon_size = 'fa-md';
        }
        
        return $this->Html->link(
            $quantity .
            $this->Html->tag('span', '', array('class' => 'fa fa-bookmark ' . $icon_size)),
            '#',
            array(
                'class' => 'link-icon-gray bookmark-link ' . $active,
                'escape' => false,
                'title' => $title
            )
        );
    }
    
    public function fullName($person)
    {
        return $person['first_name'] . ' ' . 
               $person['last_name'];
    }
    
    public function comment($comment)
    {   
        $media_left = $this->Html->div(
            'media-left', 
            $this->Html->image(
                $this->Html->avatarPath('50x50', $comment['User']), 
                array('class' => 'media-object')
            )
        );
        
        $children = '';
        if (!empty($comment['children'])) {
            $children = $this->comments($comment['children']);
        }
        
        $media_body = $this->Html->div(
            'media-body',
            $this->Html->div(
                'header',
                $this->Html->link(
                    $this->Html->tag(
                        'span', 
                        $this->fullName($comment['User']['Person']),
                        array('class' => 'fullname')
                    ),
                    array(
                        'controller' => 'people',
                        'action' => 'view',
                        $comment['User']['Person']['id'],
                        'admin' => false
                    ),
                    array('escape' => false)
                ) . '&nbsp;' .
                $this->Html->tag(
                    'span', 
                    ' ' . $this->Html->dateFormat('d.m.Y', $comment['Comment']['created']) .
                    ' ' . __('in') . ' ' . $this->Html->dateFormat('H:i', $comment['Comment']['created'])
                    ,
                    array('class' => 'date')
                )
            ) . $this->Html->div('body', $comment['Comment']['body']) .
            $this->Html->div(
                'footer',
                $this->Html->link(__('Reply'), '#',
                    array(
                        'class' => 'reply-comment',
                        'data-reply-comment-id' => $comment['Comment']['id']
                    )
                )
            ) . 
            $this->Html->div('reply-comment-block', '', array('data-reply-comment-block-id' => $comment['Comment']['id'])) . $children
        );
        
        $comment_block = $media_left . $media_body;

                            
        if (empty($comment['Comment']['parent_id'])) {
            $media = $this->Html->tag('li', $comment_block, array('class' => 'media', 'name' => 'comment_' . $comment['Comment']['id']));
        } else {
            $media = $this->Html->div('media', $comment_block, array('name' => 'comment_' . $comment['Comment']['id']));
        }
        
        return $media;
    }
    
    
    
    public function comments($comments)
    {
        $comments_list = '';
        foreach($comments as $comment) {
            $comments_list .= $this->comment($comment);
        }
        
        return $comments_list;
    }
    
    
    public function viewerNav($collection, $edit = false)
    {
        $linkPrev = '';
        $linkNext = '';
        
        if (!empty($collection['itemsPrev'])) {
            $itemsPrev = $collection['itemsPrev'];
            $linkPrev = $this->Html->link(
                $this->Html->tag('i', '', array('class' => 'fa fa-angle-left')),
                $this->viewerNavUrl($itemsPrev[count($itemsPrev) - 1]['Item']['id'], $edit),
                array(
                    'class' => 'viewer-nav viewer-nav-left',
                    'escape' => false
                )
            );
        }
        
        if (!empty($collection['itemsNext'])) {
            $itemsNext = $collection['itemsNext'];
            $linkNext = $this->Html->link(
                $this->Html->tag('i', '', array('class' => 'fa fa-angle-right')),
                $this->viewerNavUrl($itemsNext[0]['Item']['id'], $edit),
                array(
                    'class' => 'viewer-nav viewer-nav-right',
                    'escape' => false
                )
            );
        }
        
        return $linkPrev . $linkNext;
    }
    
    private function viewerNavUrl($id, $edit)
    {
        if ($edit) {
            $url = array(
                'controller' => 'items', 'action' => 'edit', $id,
                'admin' => true
            );
        } else {
            $url = array(
                'controller' => 'items', 'action' => 'view', $id,
                'admin' => false
            );
        }
        
        return $url;
    }
}
