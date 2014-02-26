<?php
    echo $form->create('User', array('action' => 'edit'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save User', array('type' => 'submit'));
?>
</span>
<h1><?php echo $html->link('Users', '/users'); ?> &rsaquo; New</h1>
</div>
<div id="single_column">
<?php
    echo $form->input('User.usertype', array('label' => 'User Type'));
    echo $form->input('User.username', array('style' => 'width:70px;'));
    echo $form->input('User.first_name');
    echo $form->input('User.last_name');
    echo $form->input('User.email', array('style' => 'width:250px;'));
?>
</div>
<br /><br /><br />
<label>Password</label>
<input type="password" id="new_password" name="new_password" />
<label>Confirm Password</label>
<input type="password" id="confirm_new_password" name="confirm_new_password" />

<input type="hidden" name="creating_user" value="1" />

<?php
    echo $form->end();
?>
<br style="clear:both;" />

