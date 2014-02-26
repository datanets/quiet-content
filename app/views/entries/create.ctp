<?php
    echo $form->create('Entry', array('action' => 'edit', 'type' => 'file'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save', array('type' => 'submit', 'name' => 'save', 'value' => '1'));
?>
</span>
<h1><?php echo $html->link('Entries', '/entries'); ?> &rsaquo; New</h1>
<?php echo $html->link('+ Add Image', '/' . $this->params['url']['url'] . '#attachments', array('id' => 'add_image')); ?>
&nbsp;&nbsp;&nbsp;
<?php echo $html->link('+ Add Attachment', '/' . $this->params['url']['url'] . '#page_bottom', array('id' => 'add_attachment')); ?>
&nbsp;&nbsp;&nbsp;
<?php echo $html->link('+ Open File Manager', $site_base_url . '/file_managers', array('target' => '_blank')); ?>
&nbsp;&nbsp;&nbsp;
&uarr;<?php echo $html->link('Return to Top', '/' . $this->params['url']['url'] . '#', array('id' => 'page_top_link')); ?>
&nbsp;&nbsp;&nbsp;
</div>
<div id="left_column">
<?php
    echo '<label>Subject</label>';
    echo $form->input('Entry.subject', array('style' => 'width:60%;', 'label' => false)) . '<br />';

    echo '<label>Entry</label>';

    echo $form->input('Entry.entry', array('style' => 'width:100%;', 'label' => false, 'class' => 'entry_body'));

?>
<div id="entry_additional_uploads">
<h3>Images</h3>
<ul id="details_images" class="sortable">
</ul>
<a name="attachments"></a>
<h3>Attachments</h3>
<ul id="details_attachments" class="sortable2">
</ul>
</div>
</div>


</div>
<div id="right_column">
<h3>Details</h3>
<?php

    $date_created = date("Y-m-d H:i:s");

    echo '<ul>';
    echo '<li><div class="list_label">Date Created</div>';
    echo '<div class="list_field"><input name="data[Entry][created]" type="text" maxlength="255" value="' . $date_created . '" id="EntryCreated" class="date-selection" /></div></li>';
    echo '<li><div class="list_label">Category</div><div class="list_field">' . $form->select('Entry.entry_category_id', $entry_categories, $this->data['Entry']['entry_category_id'], array('empty' => false, 'escape' => false)) . '</div></li>';
    echo '<li><div class="list_label">Status</div><div class="list_field">' . $form->input('Entry.status_id', array('label' => false, 'selected' => '1')) . '</div></li>';
    echo '<li><div class="list_label">Splash Image</div><div class="list_field">';
    echo '&nbsp;';
    echo $form->file('Entry.splash_image');
    echo '</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field">' . $form->checkbox('Entry.no_splash_image', array('checked' => 'checked')) . 'No Splash Image</div></li>';
    echo '<li><div class="list_label">Podcast</div><div class="list_field">';
    echo '&nbsp;';
    echo $form->file('Entry.enclosure');
    echo '</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('Entry.no_enclosure', array('checked' => 'checked')) . 'No Podcast</div></li>';
    echo '<li style="margin-top:30px;"><div class="list_label">Options</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('Entry.featured_entry') . 'Featured on Homepage</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('Entry.cat_featured_entry') . 'Featured on Category Page</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox page_type">' . $form->checkbox('Entry.blank_page') . 'This is a Blank Page</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox page_type">' . $form->checkbox('Entry.link') . 'This is a Link</div></li>';
    echo '<div id="link_details" style="display:none;">';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<label>Link Text</label>';
    echo $form->input('Entry.link_text', array('style' => 'width:200px;background-color:#fff;', 'label' => false)) . '</li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<label>Link Address</label>';
    echo $form->input('Entry.link_address', array('style' => 'width:200px;background-color:#fff;', 'label' => false)) . '</li>';
    echo '</div>';
    echo '<div style="display:none;">';
    echo $form->input('existing_splash_image', array('value' => $this->data['Entry']['splash_image']));
    echo $form->input('author_created', array('value' => $user['id']));
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
<div id="dummy_item_add_image">
    <?php echo $dummy_item_add_image; ?>
</div>

<div id="dummy_item_add_attachment">
    <?php echo $dummy_item_add_attachment; ?>
</div>

<a name="page_bottom"></a>

