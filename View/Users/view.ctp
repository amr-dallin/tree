<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['title'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Thumbs 50x50'); ?></dt>
		<dd>
			<?php echo h($user['User']['thumbs_50x50']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Thumbs 120x120'); ?></dt>
		<dd>
			<?php echo h($user['User']['thumbs_120x120']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facebook Profile'); ?></dt>
		<dd>
			<?php echo h($user['User']['facebook_profile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Twitter Profile'); ?></dt>
		<dd>
			<?php echo h($user['User']['twitter_profile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Instagram Profile'); ?></dt>
		<dd>
			<?php echo h($user['User']['instagram_profile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ok Profile'); ?></dt>
		<dd>
			<?php echo h($user['User']['ok_profile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vk Profile'); ?></dt>
		<dd>
			<?php echo h($user['User']['vk_profile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visited'); ?></dt>
		<dd>
			<?php echo h($user['User']['visited']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Block'); ?></dt>
		<dd>
			<?php echo h($user['User']['block']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Block Comment'); ?></dt>
		<dd>
			<?php echo h($user['User']['block_comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Blocked'); ?></dt>
		<dd>
			<?php echo h($user['User']['blocked']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Items'), array('controller' => 'items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Profiles'), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Comments'); ?></h3>
	<?php if (!empty($user['Comment'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Item Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
		<th><?php echo __('Body'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Block'); ?></th>
		<th><?php echo __('Block Comment'); ?></th>
		<th><?php echo __('Blocked'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Comment'] as $comment): ?>
		<tr>
			<td><?php echo $comment['id']; ?></td>
			<td><?php echo $comment['item_id']; ?></td>
			<td><?php echo $comment['user_id']; ?></td>
			<td><?php echo $comment['parent_id']; ?></td>
			<td><?php echo $comment['lft']; ?></td>
			<td><?php echo $comment['rght']; ?></td>
			<td><?php echo $comment['body']; ?></td>
			<td><?php echo $comment['created']; ?></td>
			<td><?php echo $comment['modified']; ?></td>
			<td><?php echo $comment['block']; ?></td>
			<td><?php echo $comment['block_comment']; ?></td>
			<td><?php echo $comment['blocked']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'comments', 'action' => 'view', $comment['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'comments', 'action' => 'edit', $comment['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'comments', 'action' => 'delete', $comment['id']), array('confirm' => __('Are you sure you want to delete # %s?', $comment['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Items'); ?></h3>
	<?php if (!empty($user['Item'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Album Id'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Start Year'); ?></th>
		<th><?php echo __('End Year'); ?></th>
		<th><?php echo __('Orientation'); ?></th>
		<th><?php echo __('Thumbs 75x75'); ?></th>
		<th><?php echo __('Thumbs 150x150'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Verification'); ?></th>
		<th><?php echo __('Verification Comment'); ?></th>
		<th><?php echo __('Verified'); ?></th>
		<th><?php echo __('Publish'); ?></th>
		<th><?php echo __('Publicated'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Item'] as $item): ?>
		<tr>
			<td><?php echo $item['id']; ?></td>
			<td><?php echo $item['user_id']; ?></td>
			<td><?php echo $item['album_id']; ?></td>
			<td><?php echo $item['type']; ?></td>
			<td><?php echo $item['description']; ?></td>
			<td><?php echo $item['start_year']; ?></td>
			<td><?php echo $item['end_year']; ?></td>
			<td><?php echo $item['orientation']; ?></td>
			<td><?php echo $item['thumbs_75x75']; ?></td>
			<td><?php echo $item['thumbs_150x150']; ?></td>
			<td><?php echo $item['created']; ?></td>
			<td><?php echo $item['modified']; ?></td>
			<td><?php echo $item['verification']; ?></td>
			<td><?php echo $item['verification_comment']; ?></td>
			<td><?php echo $item['verified']; ?></td>
			<td><?php echo $item['publish']; ?></td>
			<td><?php echo $item['publicated']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'items', 'action' => 'view', $item['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'items', 'action' => 'edit', $item['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'items', 'action' => 'delete', $item['id']), array('confirm' => __('Are you sure you want to delete # %s?', $item['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Profiles'); ?></h3>
	<?php if (!empty($user['Profile'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Father Id'); ?></th>
		<th><?php echo __('Mother Id'); ?></th>
		<th><?php echo __('Last Name'); ?></th>
		<th><?php echo __('First Name'); ?></th>
		<th><?php echo __('Second Name'); ?></th>
		<th><?php echo __('Biography'); ?></th>
		<th><?php echo __('Birthday'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Profile'] as $profile): ?>
		<tr>
			<td><?php echo $profile['id']; ?></td>
			<td><?php echo $profile['user_id']; ?></td>
			<td><?php echo $profile['father_id']; ?></td>
			<td><?php echo $profile['mother_id']; ?></td>
			<td><?php echo $profile['last_name']; ?></td>
			<td><?php echo $profile['first_name']; ?></td>
			<td><?php echo $profile['second_name']; ?></td>
			<td><?php echo $profile['biography']; ?></td>
			<td><?php echo $profile['birthday']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'profiles', 'action' => 'view', $profile['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'profiles', 'action' => 'edit', $profile['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'profiles', 'action' => 'delete', $profile['id']), array('confirm' => __('Are you sure you want to delete # %s?', $profile['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
