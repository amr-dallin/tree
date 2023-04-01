<?php
$this->start('title');
echo $this->Html->titleForLayout(__('All users'));
$this->end();

$this->start('nav');
$menu[3][1] = true;
echo $this->element('admin_nav', array('menu' => $menu));
$this->end();

$this->start('css-include');
echo $this->Html->css('datatables.min');
$this->end();

$this->start('jinclude');
echo $this->Html->script(
    array(
        'datatables.min', 
        'clipboard.min'
    )
);
$this->end();
?>

<?php $this->start('jinclude'); ?>
<script>

    $(document).ready( function () {
        $('[data-toggle="tooltip"]').tooltip();
        var clipboard = new ClipboardJS('.fa-clipboard');

        $('#datatable').DataTable({
            responsive: true,
            order: [[ 3, "desc" ]],
            iDisplayLength: 50
        });
    } );
</script>
<?php $this->end(); ?>

<div class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo __('Users'); ?></h2>
                <hr/>
            </div>
            <div class="col-md-12">
                <table id="datatable" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th data-priority="1"><?php echo __('Username'); ?></th>
                            <th data-priority="3"><?php echo __('Person'); ?></th>
                            <th data-priority="6"><?php echo __('Email'); ?></th>
                            <th data-priority="4"><?php echo __('Visited'); ?></th>
                            <th data-priority="5" class="text-center"><?php echo __('Data'); ?></th>
                            <th data-priority="2" style="background: none; cursor: inherit;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo '@' . $user['User']['username']; ?></td>
                            <td><?php echo $user['Person']['full_name']; ?></td>
                            <td><?php echo $user['User']['email']; ?></td>
                            <td><?php echo $user['User']['visited']; ?></td>
                            <td class="text-center">
                                <i 
                                    class="btn btn-default fa fa-clipboard" 
                                    data-clipboard-text="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'direct', 'admin' => false, md5($user['User']['id'] . $user['User']['created'])), true); ?>" 
                                    data-toggle="tooltip" 
                                    data-placement="bottom" 
                                    title="<?php echo __('Copy!'); ?>" 
                                />
                            </td>
                            <td class="text-center">
                            <?php
                            echo $this->Html->link(
                                $this->Html->tag('i', '', array('class' => 'fa fa-pencil')),
                                array('action' => 'edit', $user['User']['id'], 'admin' => true),
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
