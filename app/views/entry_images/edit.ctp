<div class="entryImages form">
<?php echo $this->Form->create('EntryImage');?>
	<fieldset>
 		<legend><?php __('Edit Entry Image'); ?></legend>
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('EntryImage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('EntryImage.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Entry Images', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>