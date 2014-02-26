<div class="helps index">
	<h2><?php __('Helps');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('lft');?></th>
			<th><?php echo $this->Paginator->sort('rgt');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('entry');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('updated');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($helps as $help):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $help['Help']['id']; ?>&nbsp;</td>
		<td><?php echo $help['Help']['lft']; ?>&nbsp;</td>
		<td><?php echo $help['Help']['rgt']; ?>&nbsp;</td>
		<td><?php echo $help['Help']['title']; ?>&nbsp;</td>
		<td><?php echo $help['Help']['entry']; ?>&nbsp;</td>
		<td><?php echo $help['Help']['created']; ?>&nbsp;</td>
		<td><?php echo $help['Help']['updated']; ?>&nbsp;</td>
		<td><?php echo $help['Help']['type']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $help['Help']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $help['Help']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $help['Help']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $help['Help']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Help', true), array('action' => 'add')); ?></li>
	</ul>
</div>