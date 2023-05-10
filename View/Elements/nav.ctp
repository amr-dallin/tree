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
                __('Family'),
                array(
                    'controller' => 'items',
                    'action' => 'index',
                    'admin' => false
                ),
                array(
                    'class' => 'navbar-brand',
                    'escape' => false
                )
            );
            ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?php if (isset($menu[1])) echo 'active'; ?>">
                <?php
                echo $this->Html->link(
                    __('Mediafiles'),
                    array(
                        'controller' => 'items',
                        'action' => 'index',
                        'admin' => false
                    ),
                    array('title' => __('Mediafiles'))
                );
                ?>
                </li>
                <li class="<?php if (isset($menu[2])) echo 'active'; ?>">
                <?php
                echo $this->Html->link(
                    __('Tree'),
                    array(
                        'controller' => 'people',
                        'action' => 'index',
                        'admin' => false
                    ),
                    array('title' => __('Tree'))
                );
                ?>
                </li>
                
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown <?php if (isset($menu[3])) echo 'active'; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $this->Session->read('Auth.User.User.username'); ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="<?php if (isset($menu[3][0])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('I was tagged'),
                            array(
                                'controller' => 'marks',
                                'action' => 'index',
                                'admin' => false
                            ),
                            array('title' => __('I was tagged'))
                        );
                        ?>
                        </li>
                        <li class="<?php if (isset($menu[3][1])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Bookmarks'),
                            array(
                                'controller' => 'bookmarks',
                                'action' => 'index',
                                'admin' => false
                            ),
                            array('title' => __('Bookmarks'))
                        );
                        ?>
                        </li>
                        <li class="<?php if (isset($menu[3][2])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Uploads'),
                            array(
                                'controller' => 'items',
                                'action' => 'uploads',
                                'admin' => false
                            ),
                            array('title' => __('Uploads'))
                        );
                        ?>
                        </li>

                        <li role="separator" class="divider"></li>
                        <?php if ($this->Html->loggedInUserGroup(array(1, 3))): ?>
                        <li>
                        <?php
                        echo $this->Html->link(
                            __('Control Panel'),
                            array(
                                'controller' => 'pages',
                                'action' => 'dashboard',
                                'admin' => true
                            ),
                            array('title' => __('Control Panel'))
                        );
                        ?>
                        </li>
                        <?php endif; ?>
                        <li class="<?php if (isset($menu[3][3])) echo 'active'; ?>">
                        <?php
                        echo $this->Html->link(
                            __('Settings'),
                            array(
                                'controller' => 'users',
                                'action' => 'edit',
                                'admin' => false
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
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->

    </div><!-- /.container -->
</nav>