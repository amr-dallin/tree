<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Add user'));
$this->end();

$this->start('ribbon');
$breadcrumbs = array(
    array(
        'title' => 'Users',
        'url' => array(
            'controller' => 'users',
            'action' => 'index'
        )
    ),
    array(
        'title' => __('Add user')
    )
);
echo $this->element('ribbon', array('breadcrumbs' => $breadcrumbs));
$this->end();

$this->start('headline');
echo $this->element(
    'headline', 
    array('title' => __('Add user'))
);
$this->end();

$this->start('navigation');
$menu['users'] = array(0 => true);
echo $this->element('navigation', array('menu' => $menu));
$this->end();
?>


<section class="">
    <div class="row">
        <article class="col-sm-12 col-md-12 col-lg-6">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-custombutton="false">
                <header></header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->		
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">
                    <?php
                    echo $this->Form->create(
                        'User',
                        array(
                            'class' => 'smart-form', 
                            'autocomplete' => 'off'
                        )
                    );
                    ?>
                        <fieldset>
                            <section>
                            <?php
                            echo $this->Form->input(
                                'username',
                                array(
                                    'div' => false,
                                    'label' => false,
                                    'placeholder' => __('Username'),
                                    'between' => '<label class="input">',
                                    'after' => '</label>'
                                )
                            );
                            ?>
                            </section>
                        </fieldset>
                        <footer>
                        <?php 
                        echo $this->Form->submit(
                            __('Save'),
                            array('class' => 'btn btn-primary')
                        );
                        ?>
                        </footer>
                    <?php echo $this->Form->end(); ?>				
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
    </div>
</section>