<?php
/**
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

<?php if (!empty($albums)): ?>
<div class="row">
    <div class="col-sm-8">
        <h2><?php echo __('Albums'); ?></h2>
    </div>
    <div class="col-sm-4">
        <ul class="control-panel-list">
            <li class="last-item">
            <?php
            if ($this->Html->loggedInUserGroup(array(1, 3))) {
                echo $this->Html->link(__('Create album'), array(
                    'controller' => 'albums',
                    'action' => 'add',
                    'admin' => true
                ));
            }
            ?>
            </li>
        </ul>
    </div>
</div>
<div class="albums"><?php echo $this->Item->albums($albums); ?></div>
<?php endif; ?>

<?php if (!empty($items)): ?>
<div class="row">
    <div class="col-md-12">
        <h2><?php echo __('Mediafiles'); ?></h2>
    </div>
    <div class="col-md-12">
    <?php echo $this->Item->items($items, array('bookmark')); ?>
    </div>
</div>
<?php endif; ?>