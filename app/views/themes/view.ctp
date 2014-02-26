<div class="themes view">
<h2><?php  __('Theme');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $theme['Theme']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $theme['Theme']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $theme['Theme']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Filename'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $theme['Theme']['filename']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Theme', true), array('action' => 'edit', $theme['Theme']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Theme', true), array('action' => 'delete', $theme['Theme']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $theme['Theme']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Themes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Theme', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
