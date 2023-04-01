<?php
$this->start('title');
echo $this->Html->titleForLayout(__('People'));
$this->end();

$this->start('nav');
$menu[2][1] = true;
echo $this->element('admin_nav', array('menu' => $menu));
$this->end();

$this->start('css-include');
echo $this->Html->css('datatables.min');
$this->end();

$this->start('jinclude');
echo $this->Html->script('datatables.min');
$this->end();
?>

<?php $this->start('jinclude'); ?>
<script>
$(document).ready( function () {
    $('#datatable').DataTable({
        responsive: true,
        iDisplayLength: 50
    });
} );
</script>
<?php $this->end(); ?>

<div class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo __('People'); ?></h2>
                <hr/>
            </div>
            <div class="col-md-12">
                <table id="datatable" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th data-class="expand" data-priority="1"><?php echo __('Full Name'); ?></th>
                            <th class="text-center"><?php echo __('Gender'); ?></th>
                            <th class="text-center"><?php echo __('Birthday'); ?></th>
                            <th data-priority="3" class="text-center"><?php echo __('Marks'); ?></th>
                            <th data-priority="4" class="text-center"><?php echo __('Users'); ?></th>
                            <th data-priority="2" style="background: none; cursor: inherit;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($people as $person): ?>
                        <tr>
                            <td><?php echo $person['Person']['full_name']; ?></td>
                            <td class="text-center">
                            <?php
                            switch($person['Person']['gender']) {
                                case 1:
                                    echo __('Male');
                                    break;
                                case 2:
                                    echo __('Female');
                                    break;
                            }
                            ?>
                            </td>
                            <td class="text-center">
                            <?php echo $this->Html->dateFormat('d:m:Y', $person['Person']['birthday']); ?>
                            </td>
                            <td class="text-center"><?php echo count($person['Mark']); ?></td>
                            <td class="text-center">
                            <?php
                            if (!empty($person['User']['id'])) {
                                echo '@' . $person['User']['username'];
                            } else {
                                echo $this->Html->link(
                                    __('Add an account'), 
                                    array(
                                        'controller' => 'users',
                                        'action' => 'add',
                                        $person['Person']['id'],
                                        'admin' => true
                                    ),
                                    array(
                                        'class' => array('btn btn-default btn-xs')
                                    )
                                );
                            }
                            ?>
                            </td>
                            <td class="text-center">
                            <?php
                            echo $this->Html->link(
                                $this->Html->tag('i', '', array('class' => 'fa fa-pencil')),
                                array('action' => 'edit', $person['Person']['id'], 'admin' => true),
                                array('escape' => false)
                            );
                            ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
