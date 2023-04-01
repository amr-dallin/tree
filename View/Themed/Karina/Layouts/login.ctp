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
    <?php echo $this->Html->charset(); ?>
        <title><?php echo $this->fetch('title'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Site Description Here">
    <?php
    echo $this->Html->css(
        array(
            'bootstrap',
            'stack-interface',
            'socicon',
            'lightbox.min',
            'flickity',
            'iconsmind',
            'jquery.steps',
            'theme',
            'custom',
            'https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700%7CMerriweather:300,300i',
            'https://fonts.googleapis.com/icon?family=Material+Icons'
        )
    );
    ?>
    </head>
    <body class=" ">
        <a id="start"></a>
        <div class="nav-container"></div>

        <div class="main-container">
        <?php echo $this->fetch('content'); ?>
        </div>

        <!--<div class="loader"></div>-->
        <a class="back-to-top inner-link" href="#start" data-scroll-class="100vh:active">
            <i class="stack-interface stack-up-open-big"></i>
        </a>

    <?php 
    echo $this->Html->script(array(
        'jquery-3.1.1.min',
        'flickity.min',
        'easypiechart.min',
        'parallax',
        'typed.min',
        'datepicker',
        'isotope.min',
        'ytplayer.min',
        'lightbox.min',
        'granim.min',
        'jquery.steps.min',
        'countdown.min',
        'twitterfetcher.min',
        'spectragram.min',
        'smooth-scroll.min',
        'scripts'
    )); 
    ?>
    </body>
</html>