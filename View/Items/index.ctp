<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Media files'));
$this->end();

$this->start('nav');
$menu[1] = true;
echo $this->element('nav', array('menu' => $menu));
$this->end();

/*
$this->start('search-page');
echo 'search-page';
$this->end();
*/

$this->start('jinclude');
echo $this->Html->script('items-grid');
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.gallery').on('click', '.more', function(){
            $('.albums div.row').children().css('display', 'block');
            $('.more').remove();
        });
        
        $('.items').on('click', '.trash', function (e) {
            e.preventDefault();

            var item_id = $(this).closest('.item').attr('id');
            
            var options = {
                'item_id': item_id,
                'title': '<?php echo __('Are you sure you want to delete the media file? After deletion, restoration is impossible.'); ?>',
                'url': '<?php echo $this->Html->url(array('controller' => 'items', 'action' => 'delete', 'admin' => true)); ?>'
            };
            
            confirmAction(options);


        });
        
    });
</script>
<?php $this->end(); ?>

<!--
<div class="search navbar-fixed-top">
    <div class="container">
        <div class="row">
            <form>
                <div class="col-md-8">
                    <div class="title-form">Поиск производится по альбомам и медиафайлам</div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Введите поисковый запрос (например, свадьба)">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="title-form">Укажите период съемки</div>
                    <div class="form-group">
                        <input type="text" class="form-control date pull-left" placeholder="Search for...">
                        <input type="text" class="form-control date pull-right" placeholder="Search for...">
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
-->



<div class="gallery bg-gray-lighter">
    
    <div class="container">    
    <?php
    if (!empty($items) || !empty($albums)) {
        echo $this->element('media');
    } else {
        echo $this->Html->div('text-empty', __('Media files not found'));
    }
    ?>
    </div>
</div>