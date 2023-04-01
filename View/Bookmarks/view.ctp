<div class="bookmarks view">
<h2><?php echo __('Bookmark'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($bookmark['Bookmark']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($bookmark['User']['id'], array('controller' => 'users', 'action' => 'view', $bookmark['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Item'); ?></dt>
		<dd>
			<?php echo $this->Html->link($bookmark['Item']['title'], array('controller' => 'items', 'action' => 'view', $bookmark['Item']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($bookmark['Bookmark']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Bookmark'), array('action' => 'edit', $bookmark['Bookmark']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Bookmark'), array('action' => 'delete', $bookmark['Bookmark']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $bookmark['Bookmark']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookmarks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookmark'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Items'), array('controller' => 'items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
	</ul>
</div>
