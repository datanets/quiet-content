<div class="attachmentAttachments view">
<h2><?php  __('Announcement Attachment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $attachmentAttachment['AnnouncementAttachment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $attachmentAttachment['AnnouncementAttachment']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Announcement'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($attachmentAttachment['Announcement']['id'], array('controller' => 'announcements', 'action' => 'view', $attachmentAttachment['Announcement']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Announcement Attachment', true), array('action' => 'edit', $attachmentAttachment['AnnouncementAttachment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Announcement Attachment', true), array('action' => 'delete', $attachmentAttachment['AnnouncementAttachment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attachmentAttachment['AnnouncementAttachment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcement Attachments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement Attachment', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement', true), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>
