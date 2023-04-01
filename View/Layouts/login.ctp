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
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-59289785-3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-59289785-3');
        </script>

        <title><?php echo $this->fetch('title'); ?></title>
        <?php echo $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo $this->Html->css('main'); ?>
    </head>
    <body>
        <?php echo $this->element('nav_login'); ?>

        <div class="main">
        <?php
        echo $this->Flash->render();
        echo $this->fetch('content');
        ?>
        </div>

        <?php 
        echo $this->Html->script(array(
            'jquery.min',
            'bootstrap.min',
            'pnotify.custom',
            'scripts'
        ));
        echo $this->fetch('jinclude');
        echo $this->fetch('jscript');
        ?>
    </body>
</html>