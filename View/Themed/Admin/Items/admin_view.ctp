<?php
$this->start('title');
echo $this->Html->titleForLayout($this->Item->titleParam($this->params['param']));
$this->end();

$this->start('ribbon');
$breadcrumbs = array($this->Item->ribbonParam($this->params['param']));
echo $this->element('ribbon', array('breadcrumbs' => $breadcrumbs));
$this->end();

$this->start('navigation');
$menu['items'] = $this->Item->navigationParam($this->params['param']);
echo $this->element('navigation', array('menu' => $menu));
$this->end();

$this->start('jinclude');
echo $this->Html->script(array(
    'plugin/x-editable/jquery.mockjax.min',
    'plugin/x-editable/moment.min',
    'plugin/x-editable/x-editable.min'
));
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.x-editable-item-field').editable({
            ajaxOptions: {
                dataType: 'json'
            },
            pk: '<?php echo h($item['Item']['id']); ?>',
            url: '<?php echo $this->Html->url(array('controller' => 'items', 'action' => 'edit', 'admin' => true)); ?>',
            success: function(response) {
                if (response !== null && response.status === 'error') {
                    return response.msg;
                }
            }
        });
        
        $('.x-editable-item-year').editable({
            ajaxOptions: {
                dataType: 'json'
            },
            type: 'select',
            source: '<?php echo $this->Html->yearList(); ?>',
            showbuttons: false,
            pk: '<?php echo h($item['Item']['id']); ?>',
            url: '<?php echo $this->Html->url(array('controller' => 'items', 'action' => 'edit', 'admin' => true)); ?>',
            success: function(response) {
                if (response !== null && response.status === 'error') {
                    return response.msg;
                }
            }
        });
    });
</script>
<?php $this->end(); ?>


<div class="row hidden-mobile">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa-fw fa fa-puzzle-piece"></i> 
			App Views <span>>
			Gallery </span></h1>
	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">
		<div class="page-title">
        <?php echo $this->Item->mode($item); ?>
		</div>
	</div>
</div>

<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <!-- widget options:
                    usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                    
                    data-widget-colorbutton="false"	
                    data-widget-editbutton="false"
                    data-widget-togglebutton="false"
                    data-widget-deletebutton="false"
                    data-widget-fullscreenbutton="false"
                    data-widget-custombutton="false"
                    data-widget-collapsed="true" 
                    data-widget-sortable="false"
                    
                -->
                <header></header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                        <input class="form-control" type="text">	
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">

                        <div class="row">
                            <div class="col-sm-9">
                                
                                <?php echo $this->Item->photoViewerAdmin($item); ?>
                                
                            </div>
                            <div class="col-sm-3">
                            <?php
                            echo $this->Html->image(
                                ITEM . h($item['Item']['thumbs_150x150']),
                                array('class' => 'img-thumbnail')
                            );
                            
                            echo $this->Html->image(
                                ITEM . h($item['Item']['thumbs_75x75']),
                                array('class' => 'img-thumbnail')
                            );
                            ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h2>
                                <?php
                                echo $this->Html->link(
                                    h($item['Item']['title']), 
                                    '#', 
                                    array(
                                        'data-type' => 'text',
                                        'data-name' => 'title', 
                                        'data-title' => __('Title'), 
                                        'class' => 'x-editable-item-field'
                                    )
                                );
                                ?>
                                </h2>
                                <p class="lead">
                                <?php
                                echo $this->Html->link(
                                    h($item['Item']['description']), 
                                    '#', 
                                    array(
                                        'data-type' => 'textarea',
                                        'data-name' => 'description', 
                                        'data-title' => __('Description'), 
                                        'class' => 'x-editable-item-field'
                                    )
                                );
                                ?>
                                </p>
                                <div>
                                <?php
                                echo $this->Html->link(
                                    h($item['Item']['start_year']), 
                                    '#', 
                                    array(
                                        'data-name' => 'start_year',
                                        'data-title' => __('Start Year'), 
                                        'class' => 'x-editable-item-year'
                                    )
                                );
                                ?>
                                </div>
                                <?php
                                echo $this->Html->link(
                                    h($item['Item']['end_year']), 
                                    '#', 
                                    array(
                                        'data-name' => 'end_year',
                                        'data-title' => __('End Year'), 
                                        'class' => 'x-editable-item-year'
                                    )
                                );
                                ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->

        </article>
        <!-- WIDGET END -->

    </div>

    <!-- end row -->


</section>