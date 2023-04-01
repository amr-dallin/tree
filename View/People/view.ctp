<?php
$this->start('title');
echo $this->Html->titleForLayout($person['Person']['short_name']);
$this->end();

$menu[2][0] = true;
$this->start('nav');
echo $this->element('nav', array('menu' => $menu));
$this->end();

$this->start('navigation');
echo $this->element(
    'navigation_person', 
    array(
        'menu' => $menu,
        'person_id' => $person['Person']['id']
    )
);
$this->end();

$this->start('header');
echo $this->element('person_header', array('person' => $person));
$this->end();

$this->start('jinclude');
echo $this->Html->script(
    array(
        'jquery-ui-1.10.2.custom.min', 
        'primitives.min',
        'navigation'
    )
);
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        
    });
</script>
<?php $this->end(); ?>

<div class="bg-gray-lighter">
    <div class="container">
        <div class="div-text">
        <?php
        if (!empty($person['Person']['biography'])) {
            echo $person['Person']['biography'];
        } else {
            echo $this->Html->div('text-empty', __('Biography is empty'));
        }
        ?>
        </div>
    </div>
</div>
