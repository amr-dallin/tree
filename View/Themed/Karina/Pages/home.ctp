<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Home'));
$this->end();

$this->start('nav');
echo $this->element('nav');
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

    /*$(window).scroll(function () {
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
        }
    });*/

</script>
<?php $this->end(); ?>

<div class="gallery bg-gray-lighter">
    <div class="container">
        <h2>Обсуждаемые</h2>
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