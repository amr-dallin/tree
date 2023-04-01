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
                __('Ахметшины'),
                array(
                    'controller' => 'pages',
                    'action' => 'home',
                    'admin' => false
                ),
                array(
                    'class' => 'navbar-brand'
                )
            );
            ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?php if (isset($menu[0])) echo 'active'; ?>">
                <?php
                echo $this->Html->link(
                    __('Mediafiles'),
                    array(
                        'controller' => 'items',
                        'action' => 'index',
                        'admin' => false
                    ),
                    array(
                        'title' => __('Mediafiles')
                    )
                );
                ?>
                </li>
                <li class="<?php if (isset($menu[1])) echo 'active'; ?>">
                <?php
                echo $this->Html->link(
                    __('Family tree'),
                    array(
                        'controller' => 'people',
                        'action' => 'index',
                        'admin' => false
                    ),
                    array(
                        'title' => __('Family tree')
                    )
                );
                ?>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                <?php
                echo $this->Html->link(
                    $this->Html->tag('i', '', array('class' => 'fa fa-cloud-upload fa-2x', 'aria-hidden' => 'true')),
                    array(
                        'controller' => 'items',
                        'action' => 'add',
                        'admin' => false
                    ),
                    array(
                        'title' => __('Upload mediafiles'),
                        'class' => 'upload-icon-padding',
                        'escape' => false
                    )
                );
                ?>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">amr.dallin <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                        <?php
                        echo $this->Html->link(
                            __('I was tagged'),
                            array(
                                'controller' => 'items',
                                'action' => 'marks',
                                'admin' => false
                            ),
                            array(
                                'title' => __('I was tagged')
                            )
                        );
                        ?>
                        </li>
                        <li>
                        <?php
                        echo $this->Html->link(
                            __('Bookmarks'),
                            array(
                                'controller' => 'bookmarks',
                                'action' => 'index',
                                'admin' => false
                            ),
                            array(
                                'title' => __('Bookmarks')
                            )
                        );
                        ?>
                        </li>
                        <li>
                        <?php
                        echo $this->Html->link(
                            __('Uploads'),
                            array(
                                'controller' => 'items',
                                'action' => 'uploads',
                                'admin' => false
                            ),
                            array(
                                'title' => __('Uploads')
                            )
                        );
                        ?>
                        </li>

                        <li role="separator" class="divider"></li>
                        <li><a href="profile.html">Профиль</a></li>
                        <li>
                        <?php
                        echo $this->Html->link(
                            __('Logout'),
                            array(
                                'controller' => 'users',
                                'action' => 'logout',
                                'admin' => false
                            ),
                            array(
                                'title' => __('Logout')
                            )
                        );
                        ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->

    </div><!-- /.container -->
</nav>