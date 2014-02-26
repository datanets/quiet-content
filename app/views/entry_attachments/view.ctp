<div class="entryAttachments view">
<h2><?php  __('Entry Attachment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entryAttachment['EntryAttachment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entryAttachment['EntryAttachment']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Entry'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($entryAttachment['Entry']['id'], array('controller' => 'entries', 'action' => 'view', $entryAttachment['Entry']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Entry Attachment', true), array('action' => 'edit', $entryAttachment['EntryAttachment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Entry Attachment', true), array('action' => 'delete', $entryAttachment['EntryAttachment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $entryAttachment['EntryAttachment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Attachments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Attachment', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
