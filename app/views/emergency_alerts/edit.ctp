<?php
    echo $form->create('EmergencyAlert', array('action' => 'edit', 'type' => 'file'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save', array('type' => 'submit', 'name' => 'save', 'value' => '1'));
?>
</span>
<h1><?php echo $html->link('Emergency Alerts', '/emergency_alerts'); ?> &rsaquo; Edit</h1>
</div>
<div id="left_column">
<?php
    echo '<label>Subject</label>';
    echo $form->input('EmergencyAlert.subject', array('style' => 'width:60%;', 'label' => false)) . '<br />';

    echo '<label>EmergencyAlert</label>';

    echo $form->input('EmergencyAlert.entry', array('style' => 'width:100%;', 'label' => false, 'class' => 'entry_body'));
    echo $form->input('EmergencyAlert.id', array('type'=>'hidden'));

?>
</div>


</div>
<div id="right_column">
<h3>Details</h3>
<?php

    echo '<ul>';
    echo '<li><div class="list_label">Date Created</div>';
    echo '<div class="list_field"><input name="data[EmergencyAlert][created]" type="text" maxlength="255" value="' . preg_replace('/\ (.*)$/', '', $this->data['EmergencyAlert']['created']) . '" id="EmergencyAlertCreated" class="date-selection" /></div></li>';
    echo '<li><div class="list_label">Status</div><div class="list_field">' . $form->input('EmergencyAlert.status_id', array('label' => false)) . '</div></li>';
    echo '<li>';
    echo '<div style="display:none;">';
    echo $form->input('existing_splash_image', array('value' => $this->data['EmergencyAlert']['splash_image']));
    echo $form->input('author_created', array('value' => $this->data['EmergencyAlert']['author_created']));
    echo $form->input('author_modified', array('value' => $user['id']));
    echo '</div>';
    echo '</li>';
    echo '</ul>';

?>
<input type="hidden" id="add_image_temporary_id_count" value="0" />
<input type="hidden" id="delete_these_images" name="delete_these_images" />

<input type="hidden" id="add_attachment_temporary_id_count" value="0" />
<input type="hidden" id="delete_these_attachments" name="delete_these_attachments" />

<?php
    echo $form->end();
?>

<!-- dummy items for when no other items exist yet... -->

<a name="page_bottom"></a>

