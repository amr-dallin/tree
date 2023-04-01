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
        <div class="nav-container ">
            <nav class="bar bar-4 bar--transparent bar--absolute" data-fixed-at="200">
                <div class="container">
                    <div class="row">
                        <div class="col-md-1 col-md-offset-0 col-sm-2 col-sm-offset-0 col-xs-4 col-xs-offset-4">
                            <div class="bar__module">
                                <a href="index.html">
                                <?php
                                echo $this->Html->image(
                                    'logo-dark.png',
                                    array('class' => 'logo logo-dark')
                                );
                                echo $this->Html->image(
                                    'logo-light.png',
                                    array('class' => 'logo logo-light')
                                );
                                ?>
                                </a>
                            </div>
                            <!--end module-->
                        </div>
                        <div class="col-md-4 col-md-offset-0 col-sm-5 col-sm-offset-0 col-xs-8 col-xs-offset-2">
                            <div class="bar__module">
                                <a class="btn btn--sm type--uppercase" href="#">
                                    <span class="btn__text">
                                        Try Builder
                                    </span>
                                </a>
                                <a class="btn btn--sm btn--primary type--uppercase" href="#">
                                    <span class="btn__text">
                                        Buy Now
                                    </span>
                                </a>
                            </div>
                            <!--end module-->
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </nav>
            <!--end bar-->
        </div>

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