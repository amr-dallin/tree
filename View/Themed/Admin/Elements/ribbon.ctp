<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div id="ribbon">

    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
    <?php
    if (
        $this->params['controller'] == 'pages' && 
        $this->params['action'] == 'display'
    ) {
        echo $this->Html->tag('li', __('Dashboard'));
    } else {
        echo $this->Html->tag(
            'li',
            $this->Html->link(
                __('Dashboard'),
                array(
                    'controller' => 'pages', 
                    'action' => 'display'
                )
            )
        );
    }
            
    if (isset($breadcrumbs) && !empty($breadcrumbs)) {
        foreach($breadcrumbs as $breadcrumb) {
            if (empty($breadcrumb['url'])) {
                echo $this->Html->tag('li', $breadcrumb['title']);
            } else {
                echo $this->Html->tag(
                    'li', 
                    $this->Html->link($breadcrumb['title'], $breadcrumb['url'])
                );
            }
        }
    }
    ?>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:

    <span class="ribbon-button-alignment pull-right">
    <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
    <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
    <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
    </span> -->

</div>