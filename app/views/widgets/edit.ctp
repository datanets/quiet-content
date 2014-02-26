<?php
    echo $form->create('Widget', array('action' => 'edit', 'type' => 'file'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save', array('type' => 'submit', 'name' => 'save', 'value' => '1'));
?>
</span>
<h1><?php echo $html->link('Widgets', '/preferences/widgets'); ?> &rsaquo; Edit</h1>
&nbsp;&nbsp;&nbsp;
</div>
<div id="single_column">
<?php
    echo '<h3>Widget: ' . $this->data['Widget']['title'] . '</h3>';
    echo '<label>Action Link</label>';
    echo $form->input('Widget.title', array('type' => 'hidden'));
    echo $form->input('Widget.action_link', array('style' => 'width:600px;', 'h3' => false, 'label' => false));

    echo $form->input('Widget.id', array('type'=>'hidden'));

?>
</div>


</div>

<?php
    echo $form->end();
?>

<a name="page_bottom"></a>

