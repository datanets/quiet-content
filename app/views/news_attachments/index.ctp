<div class="newsAttachments index">
	<h2><?php __('News Attachments');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('news_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($newsAttachments as $newsAttachment):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $newsAttachment['NewsAttachment']['id']; ?>&nbsp;</td>
		<td><?php echo $newsAttachment['NewsAttachment']['name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($newsAttachment['News']['id'], array('controller' => 'entries', 'action' => 'view', $newsAttachment['News']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $newsAttachment['NewsAttachment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $newsAttachment['NewsAttachment']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $newsAttachment['NewsAttachment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $newsAttachment['NewsAttachment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New News Attachment', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New News', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
