<div class="newsAttachments form">
<?php echo $this->Form->create('NewsAttachment');?>
	<fieldset>
 		<legend><?php __('Add News Attachment'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('news_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List News Attachments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New News', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
