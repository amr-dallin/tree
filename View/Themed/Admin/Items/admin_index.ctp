<?php
$this->start('title');
echo $this->Html->titleForLayout($this->Item->titleParam($this->params['param']));
$this->end();

$this->start('ribbon');
$breadcrumbs = array($this->Item->ribbonParam($this->params['param']));
echo $this->element('ribbon', array('breadcrumbs' => $breadcrumbs));
$this->end();

$this->start('headline');
echo $this->element(
    'headline', 
    array('title' => $this->Item->titleParam($this->params['param']))
);
$this->end();

$this->start('navigation');
$menu['items'] = $this->Item->navigationParam($this->params['param']);
echo $this->element('navigation', array('menu' => $menu));
$this->end();
?>

<div class="row">
	<div class="superbox col-sm-12">
    <?php foreach($items as $item): ?>
		<div class="superbox-list">
        <?php
        echo $this->Html->image(
            DS . 'assets' . DS . 'items' . DS . $item['Item']['thumbs_150x150'],
            array(
                'url' => array(
                    'controller' => 'items',
                    'action' => 'view',
                    h($item['Item']['id'])
                ),
                'class' => 'superbox-img'
            )
        );
        ?>
		</div>
    <?php endforeach; ?>
    </div>
</div>