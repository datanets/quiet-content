<?php
    echo $form->create('User', array('action' => 'your_account'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save Changes', array('type' => 'submit'));
?>
</span>
<h1><?php echo $html->link('Preferences', '/preferences'); ?> &rsaquo; Your Account (<?php echo $this->data['User']['username'] ?>)</h1>
</div>
<div id="single_column">
<?php
    echo $form->input('User.first_name');
    echo $form->input('User.last_name');
    echo $form->input('User.email', array('style' => 'width:250px;'));
    echo $form->input('User.id', array('type'=>'hidden'));
?>
</div>

<?php
    echo $form->end();
?>
<br style="clear:both;" />

