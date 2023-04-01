<?php
$this->start('title');
echo $this->Html->titleForLayout($album['Album']['title']);
$this->end();

$this->start('nav');
echo $this->element('nav');
$this->end();

$this->start('jinclude');
echo $this->Html->script(array('items-grid'));
$this->end();
?>

<?php
if ($this->Html->loggedInUserGroup(array(1))):
$this->start('jscript');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.items').on('click', '.trash', function (e) {
            e.preventDefault();

            var item_id = $(this).closest('.item').attr('id');
            
            var options = {
                'item_id': item_id,
                'text': '<?php echo __('Are you sure you want to exclude a media file from the album?'); ?>',
                'url': '<?php echo $this->Html->url(array('controller' => 'items', 'action' => 'exclusionForAlbum', 'admin' => true, $album['Album']['id'])); ?>'
            };
            
            itemDelete(options);
        });
        
    });
</script>
<?php
$this->end();
endif;
?>

<div class="bg-gray-lighter">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="album-toolbar-content">
                    <?php echo $this->Item->linkBackCollection(true); ?>
                    <?php if ($this->Html->loggedInUserGroup(array(1))): ?>
                    <ul class="list-inline pull-right">
                        <li>
                        <?php
                        echo $this->Html->link(
                            $this->Html->tag('span', '', array('class' => 'fa fa-pencil fa-lg')),
                            array(
                                'controller' => 'albums',
                                'action' => 'edit',
                                $album['Album']['id'],
                                'admin' => true
                            ), 
                            array(
                                'title' => __('Edit Album'),
                                'escape' => false
                            )
                        );
                        ?>
                        </li>
                        <li>
                        <?php
                        echo $this->Form->postLink(
                            $this->Html->tag('span', '', array('class' => 'fa fa-trash fa-lg')),
                            array(
                                'controller' => 'albums',
                                'action' => 'delete',
                                $album['Album']['id'],
                                'admin' => true
                            ), 
                            array(
                                'title' => __('Delete Album'),
                                'escape' => false,
                                'confirm' => __('Are you sure you want to delete the album?')
                            )
                        );
                        ?>
                        </li>
                    </ul>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="album-header">
                    <div class="album-header-cover">
                        <div class="album-header-bg">
                            <h1 id="title"><?php echo $album['Album']['title']; ?></h1>
                            <div id="description" data-type="textarea" class="description"><?php echo $album['Album']['description']; ?></div>
                            <a href="" class="link-more" data-toggle="modal" data-target="#albumDescription">Посмотреть полностью</a>

                        <?php if (!empty($items)): ?>
                            <div class="quantity"><?php echo __('%s Mediafiles', $album['Item'][0]['Item'][0]['quantity']); ?></div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="albumDescription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $album['Album']['title']; ?></h4>
                </div>
                <div class="modal-body">
                <?php
                if (!empty($album['Album']['description'])) {
                    echo $album['Album']['description'];
                } else {
                    echo $this->Html->div('text-empty', __('Album description is empty.'));
                }
                ?>
                </div>
            </div>
        </div>
    </div>

    <div class="gallery">
        <div class="container">
            <div class="row">  
                <div class="col-md-12">
                <?php
                echo $this->Item->items($items, array(
                    'bookmark', 'trash',
                    'textEmpty' => __('There are no media files in the album')
                ));
                ?>
                </div>
            </div>
        </div>
    </div>
</div>