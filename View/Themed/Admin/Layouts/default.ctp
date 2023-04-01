<!DOCTYPE html>
<html lang="en-us">
    <head>
    <?php echo $this->Html->charset(); ?>
        <title><?php echo $this->fetch('title'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- #CSS Links -->
        <!-- Basic Styles -->
        <?php
        echo $this->Html->css(
            array('bootstrap.min', 'font-awesome.min')
        );
        ?>

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <?php
        echo $this->Html->css(
            array(
                'smartadmin-production-plugins.min',
                'smartadmin-production.min',
                'smartadmin-skins.min'
            )
        );
        ?>

        <!-- SmartAdmin RTL Support -->
        <?php echo $this->Html->css('smartadmin-rtl.min'); ?>

        <!-- We recommend you use "your_style.css" to override SmartAdmin
             specific styles this will also ensure you retrain your customization with each SmartAdmin update.-->
        <?php echo $this->Html->css('your_style'); ?>

        <!-- #FAVICONS -->
        <?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon')); ?>
        <!--<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">-->

        <!-- GOOGLE FONT -->
        <?php echo $this->Html->css('opensans'); ?>

        <!-- #APP SCREEN / ICONS -->
        <!-- Specifying a Webpage Icon for Web Clip 
             Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <!-- <link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">-->

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <!-- <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black"> -->

        <!-- Startup image for web apps -->
        <!--<link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)"> -->

    </head>

    <!--

    TABLE OF CONTENTS.
    
    Use search to find needed section.
    
    ===================================================================
    
    |  01. #CSS Links                |  all CSS links and file paths  |
    |  02. #FAVICONS                 |  Favicon links and file paths  |
    |  03. #GOOGLE FONT              |  Google font link              |
    |  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
    |  05. #BODY                     |  body tag                      |
    |  06. #HEADER                   |  header tag                    |
    |  07. #PROJECTS                 |  project lists                 |
    |  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
    |  09. #MOBILE                   |  mobile view dropdown          |
    |  10. #SEARCH                   |  search field                  |
    |  11. #NAVIGATION               |  left panel & navigation       |
    |  12. #MAIN PANEL               |  main panel                    |
    |  13. #MAIN CONTENT             |  content holder                |
    |  14. #PAGE FOOTER              |  page footer                   |
    |  15. #SHORTCUT AREA            |  dropdown shortcuts area       |
    |  16. #PLUGINS                  |  all scripts and plugins       |
    
    ===================================================================
    
    -->

    <!-- #BODY -->
    <!-- Possible Classes

        * 'smart-style-{SKIN#}'
        * 'smart-rtl'         - Switch theme mode to RTL
        * 'menu-on-top'       - Switch to top navigation (no DOM change required)
        * 'no-menu'			  - Hides the menu completely
        * 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
        * 'fixed-header'      - Fixes the header
        * 'fixed-navigation'  - Fixes the main menu
        * 'fixed-ribbon'      - Fixes breadcrumb
        * 'fixed-page-footer' - Fixes footer
        * 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
    -->
    <body class="">

        <!-- #HEADER -->
		<?php echo $this->element('header'); ?>
        <!-- END HEADER -->

        <!-- #NAVIGATION -->
        <!-- Left panel : Navigation area -->
        <!-- Note: This width of the aside area can be adjusted through LESS variables -->
        
        <aside id="left-panel">
            
            <!-- User info -->
            <?php echo $this->element('user_info'); ?>
            <!-- end user info -->

            <!-- NAVIGATION : This navigation is also responsive-->

            <?php echo $this->fetch('navigation'); ?>

            <span class="minifyme" data-action="minifyMenu"> 
                <i class="fa fa-arrow-circle-left hit"></i> 
            </span>

        </aside>
        
		
        <!-- END NAVIGATION -->

        <!-- MAIN PANEL -->
        <div id="main" role="main">

            <!-- RIBBON -->
			<?php echo $this->fetch('ribbon'); ?>
            <!-- END RIBBON -->

            <!-- MAIN CONTENT -->
            <div id="content">
            <?php
            echo $this->fetch('headline');
            echo $this->Session->flash();
            echo $this->fetch('content');
            ?>
            </div>
            <!-- END MAIN CONTENT -->

        </div>
        <!-- END MAIN PANEL -->

        <!-- PAGE FOOTER -->
		<?php echo $this->element('footer'); ?>
        <!-- END PAGE FOOTER -->

        <!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
        Note: These tiles are completely responsive,
        you can add as many as you like
        -->
		<?php echo $this->element('shortcut'); ?>
        <!-- END SHORTCUT AREA -->

        <!--================================================== -->

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <?php
        echo $this->Html->script(
            'plugin/pace/pace.min', 
            array('data-pace-options' => '{ "restartOnRequestAfter": true }')
        );
        ?>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <?php echo $this->Html->script('libs/jquery-2.1.1.min'); ?>
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
            if (!window.jQuery) {
                document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
            }
        </script>-->

        <?php echo $this->Html->script('libs/jquery-ui-1.10.3.min'); ?>
       <!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script>
            if (!window.jQuery.ui) {
                document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
            }
        </script>-->

        <!-- IMPORTANT: APP CONFIG -->
        <?php echo $this->Html->script('app.config'); ?>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
        <?php echo $this->Html->script('plugin/jquery-touch/jquery.ui.touch-punch.min'); ?>

        <!-- BOOTSTRAP JS -->
        <?php echo $this->Html->script('bootstrap/bootstrap.min'); ?>
        
		<!-- CUSTOM NOTIFICATION -->
        <?php echo $this->Html->script('notification/SmartNotification.min'); ?>

        <!--[if IE 8]>
        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
        <![endif]-->

        <!-- MAIN APP JS FILE -->
        <?php echo $this->Html->script('app.min'); ?>

        <!-- PAGE RELATED PLUGIN(S) 
        <script src="..."></script>-->
        
        <?php echo $this->fetch('jinclude'); ?>

        <script type="text/javascript">
            $(document).ready(function () {
                pageSetUp();
            });
        </script>
        
        <?php echo $this->fetch('jscript'); ?>

    </body>

</html>