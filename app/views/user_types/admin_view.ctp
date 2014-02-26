<div class="userTypes view">
<h2><?php  __('User Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userType['UserType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userType['UserType']['title']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Type', true), array('action' => 'edit', $userType['UserType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User Type', true), array('action' => 'delete', $userType['UserType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userType['UserType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Type', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
