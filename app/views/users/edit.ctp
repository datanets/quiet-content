<?php
    echo $form->create('User', array('action' => 'edit'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save User', array('type' => 'submit'));
?>
</span>
<h1><?php echo $html->link('Users', '/users'); ?> &rsaquo; Edit</h1>
</div>
<div id="single_column">
<h3>User: <?php echo $this->data['User']['username'] ?></h3>
<?php
    echo $form->input('User.usertype', array('label' => 'User Type'));
    //echo $form->input('User.username', array('style' => 'width:70px;'));
    echo $form->input('User.first_name');
    echo $form->input('User.last_name');
    echo $form->input('User.email', array('style' => 'width:250px;'));
    echo $form->input('User.username', array('type'=>'hidden'));
    echo $form->input('User.id', array('type'=>'hidden'));
?>
</div>
<br /><br /><br />
<h3>New Password?</h3>
<label>New Password</label>
<input type="password" id="new_password" name="new_password" />
<label>Confirm New Password</label>
<input type="password" id="confirm_new_password" name="confirm_new_password" />

<?php
    echo $form->end();
?>
<br style="clear:both;" />

