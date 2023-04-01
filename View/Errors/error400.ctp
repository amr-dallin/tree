<?php
$this->layout = 'error';
/**
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">

            <div class="masthead clearfix">
                <div class="inner">

                </div>
            </div>

            <div class="inner cover">
                <h1 class="cover-heading"><?php echo $message; ?></h1>
                <p class="lead">
                    <strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php printf(
		__d('cake', 'The requested address %s was not found on this server.'),
		"<strong>'{$url}'</strong>"
	); ?>
                </p>
                <?php echo $this->Html->link(__('Go to home page'), array('controller' => 'items', 'action' => 'index')); ?>
            </div>

        </div>

    </div>

</div>
