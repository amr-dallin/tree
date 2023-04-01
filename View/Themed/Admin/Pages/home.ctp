<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Dasboard'));
$this->end();

$this->start('ribbon');
$breadcrumbs = array();
echo $this->element('Authorized/ribbon', array('breadcrumbs' => $breadcrumbs));
$this->end();

$this->start('headline');
echo $this->element('Authorized/headline', array('title' => 'Dashboard'));
$this->end();

$this->start('navigation');
$menu['dashboard'] = array();
echo $this->element('Authorized/navigation', array('menu' => $menu));
$this->end();
?>

<!-- row -->
<div class="row">

	<!-- SuperBox -->
	<div class="superbox col-sm-12">
		<div class="superbox-list">
			<img src="img/superbox/superbox-thumb-1.jpg" data-img="img/superbox/superbox-full-1.jpg" alt="My first photoshop layer mask on a high end PSD template theme" title="Miller Cine" class="superbox-img">
		</div>
		<div class="superbox-list">
			<img src="img/superbox/superbox-thumb-1.jpg" data-img="img/superbox/superbox-full-1.jpg" alt="My first photoshop layer mask on a high end PSD template theme" title="Miller Cine" class="superbox-img">
		</div>
		<div class="superbox-list">
			<img src="img/superbox/superbox-thumb-1.jpg" data-img="img/superbox/superbox-full-1.jpg" alt="My first photoshop layer mask on a high end PSD template theme" title="Miller Cine" class="superbox-img">
		</div>
		<div class="superbox-list">
			<img src="img/superbox/superbox-thumb-1.jpg" data-img="img/superbox/superbox-full-1.jpg" alt="My first photoshop layer mask on a high end PSD template theme" title="Miller Cine" class="superbox-img">
		</div>
    </div>
</div>

<script src="js/plugin/superbox/superbox.min.js"></script>

		<script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			$('.superbox').SuperBox();		
		})

		</script>