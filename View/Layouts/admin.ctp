<?php
/**
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->fetch('title'); ?></title>
        <?php echo $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        echo $this->Html->css('main');
        echo $this->fetch('css-include');
        ?>
    </head>
    <body>
        <?php echo $this->fetch('nav'); ?>

        <div class="main">
        <?php
        echo $this->fetch('user-header');
        echo $this->fetch('navigation');
        echo $this->fetch('content');
        ?>
        </div>

        <?php 
        echo $this->Html->script(array(
            'jquery.min',
            'bootstrap.min'
        ));
        echo $this->fetch('jinclude');
        echo $this->fetch('jscript');
        ?>
    </body>
</html>