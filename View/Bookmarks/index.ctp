<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Bookmarks'));
$this->end();

$menu[3][1] = true;
$this->start('nav');
echo $this->element('nav', array('menu' => $menu));
$this->end();

$this->start('navigation');
echo $this->element('navigation', array('menu' => $menu));
$this->end();

$this->start('jinclude');
echo $this->Html->script(array('items-grid', 'navigation'));
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {        
        $('.items').on('click', '.trash', function (e) {
            e.preventDefault();
            
            var options = {
                'item_id': $(this).closest('.item').attr('id'),
                'text': '<?php echo __('Are you sure you want to remove the media file from the bookmarks?'); ?>',
                'url': '<?php echo $this->Html->url(array('controller' => 'bookmarks', 'action' => 'action', 'admin' => false)); ?>'
            };
            
            itemDelete(options);
        });
        
    });
</script>
<?php $this->end(); ?>

<div class="gallery bg-gray-lighter pad-top-bottom-20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php
            echo $this->Item->items($items, array(
                'trash',
                'textEmpty' => __('No media files in bookmarks'))
            );
            ?>
            </div>
        </div>
    </div>
</div>