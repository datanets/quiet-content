<div class="attachmentAttachments form">
<?php echo $this->Form->create('AnnouncementAttachment');?>
	<fieldset>
 		<legend><?php __('Edit Announcement Attachment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('attachment_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('AnnouncementAttachment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('AnnouncementAttachment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Announcement Attachments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement', true), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>
