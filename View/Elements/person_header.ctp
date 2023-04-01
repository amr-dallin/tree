<?php
/**
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>


<div class="bg-gray-lighter-2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center" style="margin-bottom: 20px;">
                <h1><?php echo $person['Person']['full_name']; ?></h1>
                <?php if (!empty($person['Person']['birthday'])): ?>
                <span class="text-success"><?php echo __('Birthday %s', $this->Html->dateFormat('d M Y', $person['Person']['birthday'])); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


