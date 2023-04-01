<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Media'));
$this->end();

$this->start('nav');
$menu[0] = true;
echo $this->element('nav', array('menu' => $menu));
$this->end();

$this->start('search-page');
echo 'search-page';
$this->end();

$this->start('jinclude');
echo $this->Html->script('jquery.row-grid');
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".items").rowGrid();
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() == $(document).height()) {
            var page = $('.next').attr('data-page');
            $.ajax({
                type: 'GET',
                url: '<?= $this->Html->url(array('controller' => 'items', 'action' => 'next', 'admin' => false)); ?>',
                data: {page:page},
                dataType: 'html',
                beforeSend: function(){
                    //$('.next').replaceWith('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
                },
                success: function(data) {
                    $(".items").append(data);
                    $(".items").rowGrid("appended");
                    $('.next').attr('data-page', parseInt(page) + 1);
                    
                    window.history.pushState(null, null, 'items?page=' + page);
                }
            });
            
            //
            //$(".items").append('<div class="item"><a href="item.html"><img src="img/assets/2.jpg" height="200" /></a><div class="desc"><div class="title">fasdfsdf sdf sda sd</div><div class="bookmark">2 <i class="fa fa-comment"></i></div></div></div>');
            //$(".items").rowGrid("appended");
        }
    });

</script>
<?php $this->end(); ?>

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

<div class="gallery bg-gray-lighter">
    <div class="container">
        <h2>Медиафайлы <small>Всего 3500 шт.</small></h2>
        <div class="row">
            <div class="col-md-12 items">
            <?php
            foreach($items as $item) {
                echo $this->Item->item($item);
            }
            ?>
            </div>
            <div class="next" data-page="<?php echo $this->Item->dataPage($this->request->query); ?>"></div>
        </div>
    </div>
</div>