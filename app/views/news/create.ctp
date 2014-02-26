<?php
    echo $form->create('News', array('action' => 'edit', 'type' => 'file'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save', array('type' => 'submit', 'name' => 'save', 'value' => '1'));
?>
</span>
<h1><?php echo $html->link('News', '/news'); ?> &rsaquo; New</h1>
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
    echo $form->input('News.subject', array('style' => 'width:60%;', 'label' => false)) . '<br />';

    echo '<label>News</label>';

    echo $form->input('News.entry', array('style' => 'width:100%;', 'label' => false, 'class' => 'news_body', 'cols' => '30', 'rows' => '6'));

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
    echo '<div class="list_field"><input name="data[News][created]" type="text" maxlength="255" value="' . $date_created . '" id="NewsCreated" class="date-selection" /></div></li>';
    echo '<li><div class="list_label">Category</div><div class="list_field">' . $form->select('News.news_category_id', $news_categories, $this->data['News']['news_category_id'], array('empty' => false, 'escape' => false)) . '</div></li>';
    echo '<li><div class="list_label">Status</div><div class="list_field">' . $form->input('News.status_id', array('label' => false, 'selected' => '1')) . '</div></li>';
    echo '<li><div class="list_label">Splash Image</div><div class="list_field">';
    echo '&nbsp;';
    echo $form->file('News.splash_image');
    echo '</div></li>';
    echo '<li><div class="list_label">Splash Image Positioning</div><div class="list_field">' . $form->select('News.splash_image_align', $alignment_types, 'center center', array('empty' => false, 'escape' => false)) . '</div><br /></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field">' . $form->checkbox('News.no_splash_image', array('checked' => 'checked')) . 'No Splash Image</div></li>';
    echo '<li><div class="list_label">Podcast</div><div class="list_field">';
    echo '&nbsp;';
    echo $form->file('News.enclosure');
    echo '</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('News.no_enclosure', array('checked' => 'checked')) . 'No Podcast</div></li>';
    echo '<li style="margin-top:30px;"><div class="list_label">Options</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('News.featured_news') . 'Featured on Homepage</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('News.cat_featured_news') . 'Featured on Category Page</div></li>';
    echo '<div style="display:none;">';
    echo $form->input('existing_splash_image', array('value' => $this->data['News']['splash_image']));
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

