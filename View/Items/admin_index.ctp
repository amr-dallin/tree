<?php
switch($this->params['pass'][0]) {
    case 'new':
        $title = __('Unverified media');
        $menu[1][1] = true;
        break;
    case 'not_published':
        $title = __('Not published media');
        $menu[1][2] = true;
        break;
    case 'published':
        $title = __('Published media');
        $menu[1][3] = true;
        break;
    case 'without_album':
        $title = __('Media without album');
        $menu[1][4] = true;
        break;
    case 'without_description':
        $title = __('Media without description');
        $menu[1][5] = true;
        break;
}
$this->start('title');
echo $this->Html->titleForLayout($title);
$this->end();

$this->start('nav');
echo $this->element('admin_nav', array('menu' => $menu));
$this->end();

$this->start('jinclude');
echo $this->Html->script(array('jquery.row-grid', 'items-grid'));
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
                'url': '<?php echo $this->Html->url(array('controller' => 'items', 'action' => 'delete', 'admin' => true)); ?>'
            };
            
            itemDelete(options);
        });
        
    });
</script>
<?php $this->end(); ?>

<div class="gallery bg-gray-lighter">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo $title; ?></h2>
                <hr/>
            </div>
            <div class="col-md-12"> 
            <?php
            echo $this->Item->items($items, array(
                'edit_link',
                'trash',
                'textEmpty' => __('Media files not found'))
            );
            ?>
            </div>
        </div>
    </div>
</div>