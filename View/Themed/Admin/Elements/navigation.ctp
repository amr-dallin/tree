<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<nav>
    <ul>
        <!-- Dashboard menu -->
        <li class="<?php if (isset($menu['dashboard'])) echo 'active open'; ?>">
        <?php
        echo $this->Html->link(
            $this->Html->tag('i', '', array('class' => 'fa fa-lg fa-fw fa-home')).
            ' '.
            $this->Html->tag(
                'span', 
                __('Dashboard'), 
                array('class' => 'menu-item-parent')
            ),
            array('controller' => 'pages', 'action' => 'display'), 
            array('escape' => false)
        );
        ?>
        </li>
        
        <!-- Items menu -->
        <li class="<?php if (isset($menu['items'])) echo 'active open'; ?>">
        <?php 
        echo $this->Html->link(
            $this->Html->tag('i', '', array('class' => 'fa fa-lg fa-fw fa-picture-o')).
            ' '.
            $this->Html->tag(
                'span', 
                __('Media'), 
                array('class' => 'menu-item-parent')
            ),
            '#', 
            array('escape' => false)
        );
        ?>
            <ul>
                <li <?php if (isset($menu['items'][0])) echo 'class="active"'; ?>>
                <?php
                echo $this->Html->link(
                    __('Add'),
                    array(
                        'controller' => 'items', 
                        'action' => 'add'
                    )
                );
                ?>
                </li>
                <li <?php if (isset($menu['items'][1])) echo 'class="active"'; ?>>
                <?php
                echo $this->Html->link(
                    __('New'),
                    array(
                        'controller' => 'items', 
                        'action' => 'index',
                        'param' => 'new'
                    )
                );
                ?>
                </li>
                <li <?php if (isset($menu['items'][2])) echo 'class="active"'; ?>>
                <?php
                echo $this->Html->link(
                    __('Not published'),
                    array(
                        'controller' => 'items', 
                        'action' => 'index',
                        'param' => 'notpublished'
                    )
                );
                ?>
                </li>
			</ul>
		</li>
        
        <!-- Albums menu -->
        <li class="<?php if (isset($menu['albums'])) echo 'active open'; ?>">
        <?php 
        echo $this->Html->link(
            $this->Html->tag('i', '', array('class' => 'fa fa-lg fa-fw fa-folder-open')).
            ' '.
            $this->Html->tag(
                'span', 
                __('Albums'), 
                array('class' => 'menu-item-parent')
            ),
            '#', 
            array('escape' => false)
        );
        ?>
            <ul>
                <li <?php if (isset($menu['albums'][0])) echo 'class="active"'; ?>>
                <?php
                echo $this->Html->link(
                    __('Add'),
                    array(
                        'controller' => 'albums', 
                        'action' => 'add'
                    )
                );
                ?>
                </li>
                <li <?php if (isset($menu['albums'][1])) echo 'class="active"'; ?>>
                <?php
                echo $this->Html->link(
                    __('List'),
                    array(
                        'controller' => 'albums', 
                        'action' => 'index'
                    )
                );
                ?>
                </li>
			</ul>
		</li>
        
        <!-- Users menu -->
        <li class="<?php if (isset($menu['users'])) echo 'active open'; ?>">
        <?php 
        echo $this->Html->link(
            $this->Html->tag('i', '', array('class' => 'fa fa-lg fa-fw fa-user')).
            ' '.
            $this->Html->tag(
                'span', 
                __('Users'), 
                array('class' => 'menu-item-parent')
            ),
            '#', 
            array('escape' => false)
        );
        ?>
            <ul>
                <li <?php if (isset($menu['users'][0])) echo 'class="active"'; ?>>
                <?php
                echo $this->Html->link(
                    __('Add'),
                    array(
                        'controller' => 'users', 
                        'action' => 'add'
                    )
                );
                ?>
                </li>
                <li <?php if (isset($menu['users'][1])) echo 'class="active"'; ?>>
                <?php
                echo $this->Html->link(
                    __('List'),
                    array(
                        'controller' => 'users', 
                        'action' => 'index'
                    )
                );
                ?>
                </li>
			</ul>
		</li>
    </ul>
</nav>