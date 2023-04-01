<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Uploads'));
$this->end();

$menu[3][2] = true;
$this->start('nav');
echo $this->element('nav', array('menu' => $menu));
$this->end();

$this->start('navigation');
echo $this->element('navigation', array('menu' => $menu));
$this->end();

$this->start('jinclude');
echo $this->Html->script(array('jquery.row-grid', 'items-grid', 'navigation'));
$this->end();
?>

<div class="gallery bg-gray-lighter pad-top-bottom-20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php
            echo $this->Item->items($items, array(
                'bookmark',
                'textEmpty' => __('No uploaded media. At the moment, this function is not available.'))
            );
            ?>
            </div>
        </div>
    </div>
</div>