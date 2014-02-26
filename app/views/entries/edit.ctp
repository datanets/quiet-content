<?php
    echo $form->create('Entry', array('action' => 'edit', 'type' => 'file'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save', array('type' => 'submit', 'name' => 'save', 'value' => '1'));
?>
</span>
<h1><?php echo $html->link('Entries', '/entries'); ?> &rsaquo; Edit</h1>
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

    $entry = $this->data['Entry']['entry'];
    $entry = preg_replace("/\\r\\n/", "", $entry);
    $entry = preg_replace("/\<br \/\>/", "<br />\r\n", $entry);
    $entry = preg_replace("/\<br\>/", "<br />\r\n", $entry);

    echo $form->input('Entry.entry', array('style' => 'width:100%;', 'label' => false, 'class' => 'entry_body', 'value' => $entry));
    echo $form->input('Entry.id', array('type'=>'hidden'));

?>
<div id="entry_additional_uploads">
<h3>Images</h3>
<ul id="details_images" class="sortable">
<?php

    if (count($this->data['EntryImage']) > 0) {
        foreach ($this->data['EntryImage'] as $k => $v) :
            echo '<li class="record" id="img_' . $v['id'] . '">';
            echo '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_image ' . $v['id']  . '" onclick="return false;">Delete</a></div>';
            if (isset($v['name']) && $v['name']) {
                echo '<a href="' . $entry_images_base_url . $v['name'] . '" rel="prettyPhoto[images]"><img src="' . $entry_images_base_url . $v['name'] . '" /></a>';
            }
                echo '<input type="hidden" name="data[EntryImage][' . $k . '][id]" value="' . $this->data['EntryImage'][$k]['id'] . '" id="EntryImage' . $k . 'Id" />';
                echo '<input type="hidden" name="data[EntryImage][' . $k . '][entry_id]" value="' . $this->data['EntryImage'][$k]['entry_id'] . '" id="EntryImage' . $k . 'EntryId" />';
                echo '<div class="weight_box"><input type="hidden" name="data[EntryImage][' . $k . '][weight]" value="' . $this->data['EntryImage'][$k]['weight'] . '" id="EntryImage' . $k . 'Weight" /></div>';

            echo '</li>';
        endforeach;
    }

?>
</ul>
<a name="attachments"></a>
<h3>Attachments</h3>
<ul id="details_attachments" class="sortable2">
<?php

    if (count($this->data['EntryAttachment']) > 0) {
        foreach ($this->data['EntryAttachment'] as $k => $v) :
            echo '<li class="record" id="atm_' . $v['id'] . '">';
            echo '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_attachment ' . $v['id']  . '" onclick="return false;">Delete</a></div>';
            if (isset($v['name']) && $v['name']) {
                echo '<a href="' . $entry_attachments_base_url . $v['name'] . '" target="_blank">' . $v['name'] . '</a>';
            }
                echo '<input type="hidden" name="data[EntryAttachment][' . $k . '][id]" value="' . $this->data['EntryAttachment'][$k]['id'] . '" id="EntryAttachment' . $k . 'Id" />';
                echo '<input type="hidden" name="data[EntryAttachment][' . $k . '][entry_id]" value="' . $this->data['EntryAttachment'][$k]['entry_id'] . '" id="EntryAttachment' . $k . 'EntryId" />';
                echo '<div class="weight_box"><input type="hidden" name="data[EntryAttachment][' . $k . '][weight]" value="' . $this->data['EntryAttachment'][$k]['weight'] . '" id="EntryAttachment' . $k . 'Weight" /></div>';

            echo '</li>';
        endforeach;
    }

?>
</ul>
</div>
</div>


</div>
<div id="right_column">
<h3>Details</h3>
<?php

    echo '<ul>';
    echo '<li><div class="list_label">Date Created</div>';
    echo '<div class="list_field"><input name="data[Entry][created]" type="text" maxlength="255" value="' . preg_replace('/\ (.*)$/', '', $this->data['Entry']['created']) . '" id="EntryCreated" class="date-selection" /></div></li>';
    echo '<li><div class="list_label">Category</div><div class="list_field">' . $form->select('Entry.entry_category_id', $entry_categories, $this->data['Entry']['entry_category_id'], array('empty' => false, 'escape' => false)) . '</div></li>';
    echo '<li><div class="list_label">Status</div><div class="list_field">' . $form->input('Entry.status_id', array('label' => false)) . '</div></li>';
    echo '<li><div class="list_label">Splash Image</div><div class="list_field">';
    if (isset($this->data['Entry']['splash_image']) && $this->data['Entry']['splash_image']) {
        echo '<a href="' . $splash_images_base_url . $this->data['Entry']['splash_image'] . '" rel="prettyPhoto[splash_image]"><img src="' . $splash_images_base_url . $this->data['Entry']['splash_image'] . '" style="height:100px;border:0;" /></a>';
        echo '<li><div class="list_label">&nbsp;</div>' . $form->file('Entry.splash_image') . '</li>';
    } else {
        echo '&nbsp;';
        echo $form->file('Entry.splash_image');
    }
    echo '</li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field">' . $form->checkbox('Entry.no_splash_image') . 'No Splash Image</div></li>';
    echo '<li><div class="list_label">Podcast</div><div class="list_field">';
    if (isset($this->data['Entry']['enclosure']) && $this->data['Entry']['enclosure']) {
        echo '<div style="font-size:small;padding-top:5px;"><a href="' . $enclosures_base_url . $this->data['Entry']['enclosure'] . '" target="_blank">' . $this->data['Entry']['enclosure'] . '</a></div>';
        echo '<div class="list_label">&nbsp;</div>' . $form->file('Entry.enclosure');
    } else {
        echo '&nbsp;';
        echo $form->file('Entry.enclosure');
    }
    echo '</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('Entry.no_enclosure') . 'No Podcast</div></li>';
    //echo '<li><div class="list_label">Podcast Link</div>' . $form->input('Entry.enclosure', array('label' => false, 'style' => 'width:50%;'));
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
    echo $form->input('author_created', array('value' => $this->data['Entry']['author_created']));
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

