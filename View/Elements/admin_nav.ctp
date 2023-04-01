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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            echo $this->Html->link(
                __('Control Panel'),
                array(
                    'controller' => 'pages',
                    'action' => 'dashboard',
                    'admin' => true
                ),
                array('class' => 'navbar-brand')
            );
            ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                <?php
                echo $this->Html->link(
                    $this->Html->tag('i', '', array('class' => 'fa fa-angle-left')) . ' ' .
                    __('Back to site'),
                    array(
                        'controller' => 'items',
                        'action' => 'index',
                        'admin' => false
                    ),
                    array('title' => __('Back to site'), 'escape' => false)
                );
                ?>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php if (isset($menu[0])) echo 'active'; ?>">
                <?php
                echo $this->Html->link(
                    __('Comments'),
                    array(
                        'controller' => 'comments',
                        'action' => 'index',
                        'admin' => true
                    ),
                    array('title' => __('Comments'))
                );
                ?>
                </li>
                <li class="dropdown <?php if (isset($menu[1])) echo 'active'; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo __('Mediafiles'); ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="<?php if (isset($menu[1][0])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('New'), 
                            array(
                                'controller' => 'items', 
                                'action' => 'index', 
                                'param' => 'new', 
                                'admin' => true
                            ),
                            array('title' => __('New'))
                        );
                        ?>
                        </li>
                        <li class="<?php if (isset($menu[1][1])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Not Published'), 
                            array(
                                'controller' => 'items', 
                                'action' => 'index', 
                                'param' => 'not_published', 
                                'admin' => true
                            ),
                            array('title' => __('Not Published'))
                        );
                        ?>
                        </li>
                        <li class="<?php if (isset($menu[1][2])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Published'), 
                            array(
                                'controller' => 'items', 
                                'action' => 'index', 
                                'param' => 'published', 
                                'admin' => true
                            ),
                            array('title' => __('Published'))
                        );
                        ?>
                        </li>
                        <li class="<?php if (isset($menu[1][3])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Without Album'), 
                            array(
                                'controller' => 'items', 
                                'action' => 'index', 
                                'param' => 'without_album', 
                                'admin' => true
                            ),
                            array('title' => __('Without Album'))
                        );
                        ?>
                        </li>
                        <li class="<?php if (isset($menu[1][4])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Without Description'), 
                            array(
                                'controller' => 'items', 
                                'action' => 'index', 
                                'param' => 'without_description', 
                                'admin' => true
                            ),
                            array('title' => __('Without Description'))
                        );
                        ?>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li class="<?php if (isset($menu[1][5])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Create Album'), 
                            array(
                                'controller' => 'albums', 
                                'action' => 'add', 
                                'admin' => true
                            ),
                            array('title' => __('Create Album'))
                        );
                        ?>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown <?php if (isset($menu[2])) echo 'active'; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo __('People'); ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="<?php if (isset($menu[2][0])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Add person'),
                            array(
                                'controller' => 'people',
                                'action' => 'add',
                                'admin' => true
                            ),
                            array('title' => __('Add person'))
                        );
                        ?>
                        </li>
                        <li class="<?php if (isset($menu[2][1])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('All people'),
                            array(
                                'controller' => 'people',
                                'action' => 'index',
                                'admin' => true
                            ),
                            array('title' => __('All people'))
                        );
                        ?>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown <?php if (isset($menu[3])) echo 'active'; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo __('Users'); ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="<?php if (isset($menu[3][0])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Add an account'),
                            array(
                                'controller' => 'users',
                                'action' => 'add',
                                'admin' => true
                            ),
                            array('title' => __('Add an account'))
                        );
                        ?>
                        </li>
                        <li class="<?php if (isset($menu[3][1])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('All users'),
                            array(
                                'controller' => 'users',
                                'action' => 'index',
                                'admin' => true
                            ),
                            array('title' => __('All users'))
                        );
                        ?>
                        </li>
                    </ul>
                </li>

                <li class="<?php if (isset($menu[4])) echo 'active'; ?>">
                <?php
                echo $this->Html->link(
                    __('Settings'),
                    array(
                        'controller' => 'pages',
                        'action' => 'settings',
                        'admin' => true
                    ),
                    array('title' => __('Settings'))
                );
                ?>
                </li>
                
                <li>
                <?php
                echo $this->Html->link(
                    __('Logout'),
                    array(
                        'controller' => 'users',
                        'action' => 'logout',
                        'admin' => false
                    ),
                    array('title' => __('Logout'))
                );
                ?>
                </li>
            </ul>
            
        </div><!-- /.navbar-collapse -->

    </div><!-- /.container -->
</nav>