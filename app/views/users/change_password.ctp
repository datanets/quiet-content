<?php
    echo $form->create('User');
    //echo $form->create('User', array('action' => 'change_password'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save Changes', array('type' => 'submit'));
?>
</span>
<h1><?php echo $html->link('Preferences', '/preferences'); ?> &rsaquo; Change Password</h1>
</div>
<div id="single_column">
<label>Old Password</label>
<input type="password" id="old_password" name="old_password" />
<label>New Password</label>
<input type="password" id="new_password" name="new_password" />
<label>Confirm New Password</label>
<input type="password" id="confirm_new_password" name="confirm_new_password" />
<br />
<input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>" />
</div>
<?php
    echo $form->end();
?>
<br style="clear:both;" />

