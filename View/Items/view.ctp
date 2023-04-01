<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Mediafile'));
$this->end();

$this->start('nav');
echo $this->element('nav');
$this->end();

$this->start('jinclude');
echo $this->Html->script(array('scripts', 'jquery.photomarks', 'jquery.imgareaselect.min'));
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">    
    function form(comment_id)
    {
        var parent = '';
        var reply_id = '';
        if (comment_id !== undefined) {
            reply_id = 'data-reply-id = "' + comment_id + '"';
            parent = '<input name="parent_id" value="' + comment_id + '" type="hidden" />';
        }
        
        var form =  '<div class="comment-form">' +
                        '<form class="form-horizontal" ' + reply_id + '>' +
                            parent +
                            '<div class="form-group">' +
                                '<div class="col-md-12">' +
                                    '<textarea name="body" class="form-control" rows="4"></textarea>' +
                                '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                                '<div class="col-md-12">' +
                                    '<button type="submit" class="btn btn-primary">Отправить</button>' +
                                '</div>' +
                            '</div>' +
                        '</form>' +
                    '</div>';
            
        return form;
    }
    
    $(window).on('load', function() {
        $('.viewer-content').photoMarks({
            itemId: <?php echo $item['Item']['id']; ?>,
            marks: <?php echo $item['Mark']; ?>
        });
    });
    
    $(document).ready(function () {
        $('.comment-add').on('click', function (e) {
            e.preventDefault();

            $('.comment-add').css('display', 'none');
            $('.reply-comment').css('display', 'block');
            $('.reply-comment-block').html('');
            $('.comment-block').html(form());
            $('.comment-block textarea').focus();
        });

        $('.media-list').on('click', '.reply-comment', function(e){
            e.preventDefault();

            var comment_id = $(this).attr('data-reply-comment-id');

            $('.comment-block, .reply-comment-block').html('');
            $('.comment-add, .reply-comment').css('display', 'inline-block');

            $('[data-reply-comment-id = ' + comment_id + ']').css('display', 'none');

            $('[data-reply-comment-block-id = ' + comment_id + ']').html(form(comment_id));
            $('[data-reply-comment-block-id = ' + comment_id + '] textarea').focus();
        });

        $('.comment-block').on('submit', '.form-horizontal', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url(array('controller' => 'comments', 'action' => 'add', $this->params['pass'][0], 'admin' => false)); ?>',
                data: $(this).serialize(),
                dataType: 'html',
                beforeSend: function(){

                },
                success: function(data) {
                    if (data !== '') {
                        $('.comment-add').css('display', 'inline-block');
                        $('.comment-block').html('');
                        $('.media-list').append(data);

                        $('.media-list').next('.text-empty').css('display', 'none');

                        $('.media-list').animate({scrollTop: $('.media-list').prop("scrollHeight")}, 500);

                        notification('success', '<?php echo __('Comment added successfully'); ?>');
                    } else {
                        notification('error', '<?php echo __('Comment not added. Please, try again.'); ?>');
                    }

                }
            });
        });

        $('.media-list').on('submit', '.reply-comment-block .form-horizontal', function (e) {
            e.preventDefault();

            var parent_id = $(this).attr('data-reply-id');

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url(array('controller' => 'comments', 'action' => 'add', $this->params['pass'][0], 'admin' => false)); ?>',
                data: $(this).serialize(),
                dataType: 'html',
                beforeSend: function(){

                },
                success: function(data) {
                    $('.reply-comment').css('display', 'inline-block');
                    $('.reply-comment-block').html('');
                    $('[name=comment_' + parent_id + '] .media-body:first').append(data);
                    
                    notification('success', '<?php echo __('Comment added successfully'); ?>');
                }
            });
        });
        
        $('.viewer').on('click', '.bookmark-link', function(e){
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url(array('controller' => 'bookmarks', 'action' => 'action', 'admin' => false)); ?>',
                data: 'item_id=<?php echo $item['Item']['id']; ?>',
                dataType: 'json',
                beforeSend: function(){

                },
                success: function(data) {
                    
                    if (typeof data.action !== "undefined") {
                        $('#bookmark-quantity').html(data.quantity);
                        $('.bookmark-link').attr('title', data.title);
                        
                        switch(data.action) {
                            case 0:
                                $('.bookmark-link').removeClass('active');
                                break;
                            case 1:
                                $('.bookmark-link').addClass('active');
                                break;
                        }
                    }
                    
                    notification(data.status, data.message);
                }
            });
        });
        
    });
</script>
<?php $this->end(); ?>



<div class="viewer">
    <div class="container-fluid">
        <div class="row">
            <div class="viewer-top">
            <?php echo $this->Item->linkBackCollection(); ?>
                
            <?php if ($this->Html->loggedInUserGroup(array(1, 3))): ?>
                <ul class="list-inline pull-right">
                    <li>
                        <?php
                        echo $this->Html->link(
                            $this->Html->tag('span', '', array('class' => 'fa fa-pencil fa-lg')),
                            array(
                                'controller' => 'items',
                                'action' => 'edit',
                                $item['Item']['id'],
                                'admin' => true
                            ), 
                            array(
                                'title' => __('Edit'),
                                'class' => 'link-icon-gray',
                                'escape' => false
                            )
                        );
                        ?>
                    </li>
                </ul>
            <?php endif; ?>

            </div>
        </div>
        <div class="row">
            <div class="viewer-content">
                <div class="viewer-item">
                <?php echo $this->Item->viewerImage($item); ?>
                    <div class="marks-container"></div>
                </div>
                <div class="mlabels-container container">
                    <div class="col-md-8 col-md-offset-2">
                        <?php echo __('Marked on media file:'); ?>
                        <ul class="mlabels"></ul>
                    </div>

                </div>
                <?php echo $this->Item->viewerNav($collection); ?>
            </div>
        </div>
        <div class="row">
            <div class="viewer-bottom">
                
                <div class="bookmark-download visible-md visible-lg">
                <?php
                echo $this->Item->bookmarkLink($item);
                
                echo $this->Html->link(
                    $this->Html->tag('span', '', array('class' => 'fa fa-download fa-lg')),
                    array('action' => 'sendFile', 'admin' => false, $item['Item']['id']),
                    array('escape' => false, 'class' => 'link-icon-gray')
                );
                ?>
                </div>

                <div class="statistics-download visible-xs visible-sm">
                    <div class="hidden-xs col-sm-3">
                        <?php echo count($item['Comment']); ?> <i class="fa fa-comment fa-md"></i>
                    </div>
                    <div class="col-xs-4 col-sm-3">
                        <?php echo $item['Item']['quantity_views']; ?> <i class="fa fa-eye fa-md"></i>
                    </div>
                    <div class="col-xs-4 col-sm-3">
                    <?php echo $this->Item->bookmarkLink($item, true); ?>
                    </div>
                    <div class="col-xs-4 col-sm-3">
                    <?php 
                    echo $this->Html->link(
                        $this->Html->tag('span', '', array('class' => 'fa fa-download fa-md')),
                        array('action' => 'sendFile', 'admin' => false, $item['Item']['id']),
                        array('escape' => false, 'class' => 'link-icon-gray')
                    );
                    ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-lighter pad-top-bottom-20">
    <div class="container">
        
        <div class="row">
            <div class="col-md-8">
            <?php echo $this->Item->description($item); ?>
            </div>
            <div class="col-md-3 col-md-offset-1">
                <div class="row statistics hidden-xs hidden-sm">
                    <div class="col-md-4">
                        <div class="quantity"><?php echo count($item['Comment']); ?></div>
                        <span class="title"><?php echo __('Comments'); ?></span>
                    </div>
                    <div class="col-md-4">
                        <div class="quantity"><?php echo count($item['Bookmark']); ?></div>
                        <span class="title"><?php echo __('Bookmarks'); ?></span>
                    </div>
                    <div class="col-md-4">
                        <div class="quantity"><?php echo $item['Item']['quantity_views']; ?></div>
                        <span class="title"><?php echo __('Views'); ?></span>
                    </div>
                </div>
                <div class="row information">
                    <div class="col-md-12">
                        <div class="created">
                        <?php
                        echo __('Published') . ' ' . 
                            $this->Html->tag('span', 
                                __('%s in %s', 
                                    $this->Html->dateFormat('d.m.Y', $item['Item']['created']), 
                                    $this->Html->dateFormat('H:i', $item['Item']['created'])
                                ) 
                            );
                        ?>
                        </div>
                        <div class="sender">
                        <?php
                        /*
                        echo __(
                            'Sender %s', 
                            $this->Html->link(
                                $this->Item->fullname($item['User']['Person']) . 
                                ' (' . $item['User']['username'] . ')',
                                array(
                                    'controller' => 'people',
                                    'action' => 'view',
                                    $item['User']['Person']['id'],
                                    'admin' => false
                                )
                            )
                        );*/
                        ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        
        <hr/>


        <div class="row">
            <div class="col-md-12">
            <?php
            echo $this->Html->link(
                __('Add comment'), '#', array('class' => 'comment-add')
            );
            echo $this->Html->div('comment-block', '');
            
            echo $this->Html->tag(
                'ul', 
                $this->Item->comments($comments),
                array('class' => 'media-list')
            );
            
            if (!empty($comments)) {
                if (count($comments) > 3) { 
                    echo $this->Html->link(
                        __('Add comment'), '#', array('class' => 'comment-add')
                    );
                }
            } else {
                echo $this->Html->div(
                    'text-empty', __('There are no comments yet. If you have something to share for this event, please.')
                );
            }
            ?>
            </div>
        </div>
    </div>
</div>
