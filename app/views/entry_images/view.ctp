<div class="entryImages view">
<h2><?php  __('Entry Image');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entryImage['EntryImage']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entryImage['EntryImage']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Entry'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($entryImage['Entry']['id'], array('controller' => 'entries', 'action' => 'view', $entryImage['Entry']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Entry Image', true), array('action' => 'edit', $entryImage['EntryImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Entry Image', true), array('action' => 'delete', $entryImage['EntryImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $entryImage['EntryImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Images', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Image', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
