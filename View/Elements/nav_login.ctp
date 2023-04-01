<?php
/**
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>


<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <?php
            echo $this->Html->link(
                __('Family') . ' <sup><span class="label label-warning">beta</span></sup>',
                array(
                    'controller' => 'pages',
                    'action' => 'display',
                    'admin' => false
                ),
                array(
                    'class' => 'navbar-brand',
                    'escape' => false
                )
            );
            ?>
        </div>
    </div><!-- /.container -->
</nav>