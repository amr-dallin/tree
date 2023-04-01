<?php
/**
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>
<!doctype html>
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

    <?php echo $this->Html->charset(); ?>
        <title><?php echo $this->fetch('title'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $this->Html->css('display'); ?>
    </head>
    <body>
    <?php
    echo $this->Flash->render();
    echo $this->fetch('content');
    ?>

    <?php 
    echo $this->Html->script(array(
        'jquery.min',
        'bootstrap.min'
    )); 
    ?>
    </body>
</html>