<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Add album'));
$this->end();

$this->start('nav');
$menu[1][5] = true;
echo $this->element('admin_nav', array('menu' => $menu));
$this->end();

$this->start('jinclude');
echo $this->Html->script(array('jquery.row-grid', 'items-grid'));
$this->end();
?>

<?php echo $this->Form->create('Album', array('autocomplete' => 'off')); ?>
    <div class="gallery bg-gray-lighter pad-top-bottom-20">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <fieldset>
                        <?php
                        echo $this->Form->input(
                            'title', array(
                                'div' => array('class' => 'form-group'),
                                'label' => array('class' => 'sr-only'),
                                'class' => 'form-control',
                                'placeholder' => __('Album Title')
                            ));
                        
                        echo $this->Form->input(
                            'description', array(
                                'type' => 'textarea',
                                'div' => array('class' => 'form-group'),
                                'label' => array('class' => 'sr-only'),
                                'class' => 'form-control',
                                'rows' => 4,
                                'placeholder' => __('Album Description')
                            ));
                        ?>
                        <div class="form-group">
                            <div class="row">
                                <?php
                                echo $this->Form->input(
                                    'start_year', array(
                                        'type' => 'text',
                                        'div' => array('class' => 'col-xs-6'),
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => __('From')
                                    ));
                                
                                echo $this->Form->input(
                                    'end_year', array(
                                        'type' => 'text',
                                        'div' => array('class' => 'col-xs-6'),
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => __('To')
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="fixed-bottom-block">
                            <div class="opacity-white"></div>
                            <div class="row">
                            <?php
                            echo $this->Form->submit(__('Create Album'), array(
                                'div' => 'col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-5', 
                                'class' => 'btn btn-primary btn-block'
                            ));
                            ?>
                            </div>
                        </div>
                        
                    </fieldset>
                    <hr/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                <?php
                if (!empty($items)) {
                    echo $this->Item->items($items, array('checkbox', 'without_link'));
                } else {
                    echo $this->Html->div('text-empty', __('No media files to add to album.'));
                }
                ?>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->Form->end(); ?>
