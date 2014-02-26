<div class="userTypes form">
<?php echo $this->Form->create('UserType');?>
	<fieldset>
 		<legend><?php __('Admin Edit User Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserType.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Types', true), array('action' => 'index'));?></li>
	</ul>
</div>