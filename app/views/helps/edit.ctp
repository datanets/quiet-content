<div class="helps form">
<?php echo $this->Form->create('Help');?>
	<fieldset>
 		<legend><?php __('Edit Help'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('lft');
		echo $this->Form->input('rgt');
		echo $this->Form->input('title');
		echo $this->Form->input('entry');
		echo $this->Form->input('type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Help.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Help.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Helps', true), array('action' => 'index'));?></li>
	</ul>
</div>