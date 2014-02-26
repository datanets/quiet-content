<?php
    echo $form->create('News', array('action' => 'edit', 'type' => 'file'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save', array('type' => 'submit', 'name' => 'save', 'value' => '1'));
?>
</span>
<h1><?php echo $html->link('News', '/news'); ?> &rsaquo; Edit</h1>
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
    echo $form->input('News.id', array('type'=>'hidden'));

?>
<div id="entry_additional_uploads">
<h3>Images</h3>
<ul id="details_images" class="sortable">
<?php

    if (count($this->data['NewsImage']) > 0) {
        foreach ($this->data['NewsImage'] as $k => $v) :
            echo '<li class="record" id="img_' . $v['id'] . '">';
            echo '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_image ' . $v['id']  . '" onclick="return false;">Delete</a></div>';
            if (isset($v['name']) && $v['name']) {
                echo '<a href="' . $news_images_base_url . $v['name'] . '" rel="prettyPhoto[images]"><img src="' . $news_images_base_url . $v['name'] . '" /></a>';
            }
                echo '<input type="hidden" name="data[NewsImage][' . $k . '][id]" value="' . $this->data['NewsImage'][$k]['id'] . '" id="NewsImage' . $k . 'Id" />';
                echo '<input type="hidden" name="data[NewsImage][' . $k . '][news_id]" value="' . $this->data['NewsImage'][$k]['news_id'] . '" id="NewsImage' . $k . 'NewsId" />';
                echo '<div class="weight_box"><input type="hidden" name="data[NewsImage][' . $k . '][weight]" value="' . $this->data['NewsImage'][$k]['weight'] . '" id="NewsImage' . $k . 'Weight" /></div>';

            echo '</li>';
        endforeach;
    }

?>
</ul>
<a name="attachments"></a>
<h3>Attachments</h3>
<ul id="details_attachments" class="sortable2">
<?php

    if (count($this->data['NewsAttachment']) > 0) {
        foreach ($this->data['NewsAttachment'] as $k => $v) :
            echo '<li class="record" id="atm_' . $v['id'] . '">';
            echo '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_attachment ' . $v['id']  . '" onclick="return false;">Delete</a></div>';
            if (isset($v['name']) && $v['name']) {
                echo '<a href="' . $news_attachments_base_url . $v['name'] . '" target="_blank">' . $v['name'] . '</a>';
            }
                echo '<input type="hidden" name="data[NewsAttachment][' . $k . '][id]" value="' . $this->data['NewsAttachment'][$k]['id'] . '" id="NewsAttachment' . $k . 'Id" />';
                echo '<input type="hidden" name="data[NewsAttachment][' . $k . '][news_id]" value="' . $this->data['NewsAttachment'][$k]['news_id'] . '" id="NewsAttachment' . $k . 'NewsId" />';
                echo '<div class="weight_box"><input type="hidden" name="data[NewsAttachment][' . $k . '][weight]" value="' . $this->data['NewsAttachment'][$k]['weight'] . '" id="NewsAttachment' . $k . 'Weight" /></div>';

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
    echo '<div class="list_field"><input name="data[News][created]" type="text" maxlength="255" value="' . preg_replace('/\ (.*)$/', '', $this->data['News']['created']) . '" id="NewsCreated" class="date-selection" /></div></li>';
    echo '<li><div class="list_label">Category</div><div class="list_field">' . $form->select('News.news_category_id', $news_categories, $this->data['News']['news_category_id'], array('empty' => false, 'escape' => false)) . '</div></li>';
    echo '<li><div class="list_label">Status</div><div class="list_field">' . $form->input('News.status_id', array('label' => false)) . '</div></li>';
    echo '<li><div class="list_label">Splash Image</div><div class="list_field">';
    if (isset($this->data['News']['splash_image']) && $this->data['News']['splash_image']) {
        echo '<a href="' . $splash_images_base_url . $this->data['News']['splash_image'] . '" rel="prettyPhoto[splash_image]"><img src="' . $splash_images_base_url . $this->data['News']['splash_image'] . '" style="height:100px;border:0;" /></a>';
        echo '<li><div class="list_label">&nbsp;</div>' . $form->file('News.splash_image') . '</li>';
    } else {
        echo '&nbsp;';
        echo $form->file('News.splash_image');
    }
    echo '</li>';
    echo '<li><div class="list_label">Splash Image Positioning</div><div class="list_field">' . $form->select('News.splash_image_align', $alignment_types, $this->data['News']['splash_image_align'], array('empty' => false, 'escape' => false)) . '</div><br /></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field">' . $form->checkbox('News.no_splash_image') . 'No Splash Image</div></li>';
    echo '<li><div class="list_label">Podcast</div><div class="list_field">';
    if (isset($this->data['News']['enclosure']) && $this->data['News']['enclosure']) {
        echo '<div style="font-size:small;padding-top:5px;"><a href="' . $enclosures_base_url . $this->data['News']['enclosure'] . '" target="_blank">' . $this->data['News']['enclosure'] . '</a></div>';
        echo '<li><div class="list_label">&nbsp;</div>' . $form->file('News.enclosure') . '</li>';
    } else {
        echo '&nbsp;';
        echo $form->file('News.enclosure');
    }
    echo '</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('News.no_enclosure') . 'No Podcast</div></li>';
    //echo '<li><div class="list_label">Podcast Link</div>' . $form->input('News.enclosure', array('label' => false, 'style' => 'width:50%;'));
    echo '<li style="margin-top:30px;"><div class="list_label">Options</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('News.featured_news') . 'Featured on Homepage</div></li>';
    echo '<li><div class="list_label">&nbsp;</div>';
    echo '<div class="list_field_checkbox">' . $form->checkbox('News.cat_featured_news') . 'Featured on Category Page</div></li>';
    echo '<div style="display:none;">';
    echo $form->input('existing_splash_image', array('value' => $this->data['News']['splash_image']));
    echo $form->input('author_created', array('value' => $this->data['News']['author_created']));
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

