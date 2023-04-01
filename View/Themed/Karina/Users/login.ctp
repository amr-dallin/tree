<?php
$this->layout = 'login';
/*
$this->start('title');
echo $this->Html->titleForLayout(__('Users'));
$this->end();

$this->start('ribbon');
$breadcrumbs = array(
    array(
        'title' => __('User')
    )
);
echo $this->element('ribbon', array('breadcrumbs' => $breadcrumbs));
$this->end();

$this->start('headline');
echo $this->element(
    'headline', 
    array('title' => __('Users'))
);
$this->end();

$this->start('navigation');
$menu['users'] = array(1 => true);
echo $this->element('navigation', array('menu' => $menu));
$this->end();

 */
?>

<section class="height-100 imagebg text-center" data-overlay="4">
    <div class="background-image-holder">
    <?php echo $this->Html->image('inner-6.jpg'); ?>
    </div>
    <div class="container pos-vertical-center">
        <div class="row">
            <div class="col-sm-7 col-md-5">
                <h2><?php echo __('Login to continue'); ?></h2>
                <p class="lead">
                    Welcome back, sign in with your existing Stack account credentials
                </p>
                <?php echo $this->Form->create('User', array('autocomplete' => 'off')); ?>
                    <div class="row">
                    <?php
                    echo $this->Form->input(
                        'username',
                        array(
                            'div' => array('class' => 'col-sm-12'),
                            'label' => false,
                            'placeholder' => __('Username'),
                            'type' => 'text',
                        )
                    );
                    echo $this->Form->input(
                        'password',
                        array(
                            'div' => array('class' => 'col-sm-12'),
                            'label' => false,
                            'placeholder' => __('Password'),
                            'type' => 'password',
                        )
                    );
                    
                    ?>
                        <div class="col-sm-12">
                        <?php
                        echo $this->Form->submit(__('Login'), array('class' => 'btn btn--primary type--uppercase'));
                        ?>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
                <span class="type--fine-print block">Forgot your username or password?
                    <a href="page-accounts-recover.html">Recover account</a>
                </span>
            </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>