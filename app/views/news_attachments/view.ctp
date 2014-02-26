<div class="newsAttachments view">
<h2><?php  __('News Attachment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newsAttachment['NewsAttachment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newsAttachment['NewsAttachment']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('News'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($newsAttachment['News']['id'], array('controller' => 'entries', 'action' => 'view', $newsAttachment['News']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit News Attachment', true), array('action' => 'edit', $newsAttachment['NewsAttachment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete News Attachment', true), array('action' => 'delete', $newsAttachment['NewsAttachment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $newsAttachment['NewsAttachment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List News Attachments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New News Attachment', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New News', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
