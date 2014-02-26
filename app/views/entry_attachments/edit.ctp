<div class="entryAttachments form">
<?php echo $this->Form->create('EntryAttachment');?>
	<fieldset>
 		<legend><?php __('Edit Entry Attachment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('entry_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('EntryAttachment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('EntryAttachment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Attachments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>