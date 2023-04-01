<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Comments'));
$this->end();

$this->start('nav');
$menu[0] = true;
echo $this->element('admin_nav', array('menu' => $menu));
$this->end();
?>


<div class="gallery bg-gray-lighter pad-top-bottom-20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
</div>