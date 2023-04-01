<?php
$this->layout = 'display';
$this->start('title');
echo $this->Html->titleForLayout('Семейный фотоальбом');
$this->end();
?>

<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">

            <div class="masthead clearfix">
                <div class="inner">

                </div>
            </div>

            <div class="inner cover">
                <h1 class="cover-heading">Семейный фотоальбом</h1>
                <p class="lead">Единая коллекция семейных фотографий, объединяющая множество родственных семей</p>
                <p class="lead">
                    <?php echo $this->Html->link(__('Log In'), array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-primary btn-lg')); ?>
                </p>
                <p>Доступ организован только по приглашению</p>
            </div>

        </div>

    </div>

</div>

