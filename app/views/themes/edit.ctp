<div class="themes form">
<?php echo $this->Form->create('Theme');?>
	<fieldset>
 		<legend><?php __('Edit Theme'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('filename');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Theme.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Theme.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Themes', true), array('action' => 'index'));?></li>
	</ul>
</div>