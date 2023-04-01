<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Marks'));
$this->end();

if (empty($person)) {
    $menu[3][0] = true;
    $this->start('navigation');
    echo $this->element('navigation', array('menu' => $menu));
    $this->end();    
} else {
    $menu[2][2] = true;
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
}

$this->start('nav');
echo $this->element('nav', array('menu' => $menu));
$this->end();


$this->start('jinclude');
echo $this->Html->script(array('items-grid', 'navigation'));
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {

    });
</script>
<?php $this->end(); ?>

<div class="gallery bg-gray-lighter pad-top-bottom-20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php
            echo $this->Item->items($items, array(
                'bookmark',
                'textEmpty' => __('No media on which you are marked.'))
            );
            ?>
            </div>
        </div>
    </div>
</div>