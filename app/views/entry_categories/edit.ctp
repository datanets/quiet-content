<?php
    echo $form->create('EntryCategory', array('action' => 'edit', 'type' => 'file'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save', array('type' => 'submit', 'name' => 'save', 'value' => '1'));
?>
</span>
<h1><?php echo $html->link('Entry Categories', '/entry_categories'); ?> &rsaquo; Edit</h1>
&uarr;<?php echo $html->link('Return to Top', '/' . $this->params['url']['url'] . '#', array('id' => 'page_top_link')); ?>
&nbsp;&nbsp;&nbsp;
</div>
<div id="single_column">
<?php
    echo '<h3>Category Details</h3>';
    echo '<label>Category Name</label>';
    echo $form->input('EntryCategory.name', array('style' => 'width:300px;', 'h3' => false, 'label' => false));
    echo '<label>Category Type</label>';
    echo $form->select('EntryCategory.category_type', $entry_category_types, $this->data['EntryCategory']['category_type'], array('style' => '', 'h3' => false));

    echo '<div class="big_list_boxes">';
    echo '<ul>';

    echo '<li id="category_li_2">';
    echo '<h3>Category Link</h3>';
    echo '<div class="side_of_informational_box">';
    echo '<label>Link Name</label>';
    echo $form->input('EntryCategory.other_link_text', array('style' => 'width:300px;', 'h3' => false, 'label' => false));
    echo '<label>Link Address</label>';
    echo $form->input('EntryCategory.other_link', array('style' => 'width:300px;', 'h3' => false, 'label' => false));
    echo '</div>';
    echo '<div class="informational_box">';
    echo '<h1>&#9872;</h1><b>Category Link</b> is a way to turn a category into a link that goes to any type of website you would like.  It is not limited to just this website and only requires that you have a Link Address (to type or copy/paste into the <b>Link Address</b> field,) and a Link Name (to type into the <b>Link Name</b> field.)';
    echo '<br /><br />';
    echo 'Example:<br /><br /><b>Link Name:</b> Some Other Website<br /><b>Link Address:</b> http://www.some-other-website.com';
    echo '</div>';
    echo '</li>';

    echo '<li id="category_li_3">';
    echo '<h3>Category Menu</h3>';
    echo '<div id="entry_category_menu" class="side_of_informational_box">';

    echo '<div style="font-size:small;padding:10px;padding-left:0;">';
    echo $html->link('+ Add Label', '/' . $this->params['url']['url'] . '#add_label', array('id' => 'add_entry_category_label'));
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo $html->link('+ Add Link', '/' . $this->params['url']['url'] . '#add_link', array('id' => 'add_entry_category_link'));
    echo '</div>';

    echo '<ul class="sortable menu_edit_box">';

    //foreach ($this->data['EntryCategoryMenuItem'] as $menu_item) {
    for ($i = 0; $i < count($this->data['EntryCategoryMenuItem']); $i++) {

        if ($this->data['EntryCategoryMenuItem'][$i]['item_type'] == 1) {
            echo '<li id="ecl_' . $this->data['EntryCategoryMenuItem'][$i]['id'] . '" class="menu_label" style="background-color:#aaa;">';
            echo '<div style="float:right;">' . $html->link('Delete', '/' . $this->params['url']['url'] . '#delete_item', array('class' => 'delete_label ' . $this->data['EntryCategoryMenuItem'][$i]['id'], 'style' => 'font-size:small;')) . '</div>';
            echo '<div style="padding:10px;padding-top:0;">';
            echo '<label>Label</label>';
            echo '<input type="text" id="EntryCategoryMenuItem' . $i . 'Title" name="data[EntryCategoryMenuItem][' . $i . '][title]" value="' . $this->data['EntryCategoryMenuItem'][$i]['title'] . '" />';
            echo '<input type="hidden" id="EntryCategoryMenuItem' . $i . 'ItemType" name="data[EntryCategoryMenuItem][' . $i . '][item_type]" value="' . $this->data['EntryCategoryMenuItem'][$i]['item_type'] . '" />';
            echo '<input type="hidden" id="EntryCategoryMenuItem' . $i . 'Weight" name="data[EntryCategoryMenuItem][' . $i . '][weight]" value="' . $this->data['EntryCategoryMenuItem'][$i]['weight'] . '" />';
            echo '<input type="hidden" id="EntryCategoryMenuItem' . $i . 'Id" name="data[EntryCategoryMenuItem][' . $i . '][id]" value="' . $this->data['EntryCategoryMenuItem'][$i]['id'] . '" />';
            echo '</div>';
            echo '</li>';
        } else {
            echo '<li id="ecl_' . $this->data['EntryCategoryMenuItem'][$i]['id'] . '" class="menu_link">';
            echo '<div style="float:right;">' . $html->link('Delete', '/' . $this->params['url']['url'] . '#delete_item', array('class' => 'delete_link ' . $this->data['EntryCategoryMenuItem'][$i]['id'], 'style' => 'font-size:small;')) . '</div>';
            echo '<div style="padding:10px;padding-top:0;">';
            echo '<label>Entry Link</label>';
            echo $form->select('EntryCategory.link', $entry_category_list, $this->data['EntryCategoryMenuItem'][$i]['link'], array('id' => 'EntryCategoryMenuItem' . $i . 'Link', 'name' => 'data[EntryCategoryMenuItem][' . $i . '][link]'));
            echo '<input type="hidden" id="EntryCategoryMenuItem' . $i . 'ItemType" name="data[EntryCategoryMenuItem][' . $i . '][item_type]" value="' . $this->data['EntryCategoryMenuItem'][$i]['item_type'] . '" />';
            echo '<input type="hidden" id="EntryCategoryMenuItem' . $i . 'Weight" name="data[EntryCategoryMenuItem][' . $i . '][weight]" value="' . $this->data['EntryCategoryMenuItem'][$i]['weight'] . '" />';
            echo '<input type="hidden" id="EntryCategoryMenuItem' . $i . 'Id" name="data[EntryCategoryMenuItem][' . $i . '][id]" value="' . $this->data['EntryCategoryMenuItem'][$i]['id'] . '" />';
            echo '<div style="padding-top:10px;font-size:x-small;"><a href="' . $this->params['url']['url'] . '#have_another_link_to_use" class="have_another_link_to_use">Have another link to use?</a></div>';

            if ($this->data['EntryCategoryMenuItem'][$i]['other_link_text'] || $this->data['EntryCategoryMenuItem'][$i]['other_link'])
                echo '<div class="category_menu_other_link_box" style="display:block;">';
            else
                echo '<div class="category_menu_other_link_box">';

            echo '<label>Link Text</label><input type="text" id="EntryCategoryMenuItem' . $i . 'OtherLinkText" name="data[EntryCategoryMenuItem][' . $i . '][other_link_text]" value="' . $this->data['EntryCategoryMenuItem'][$i]['other_link_text'] . '" style="width:300px;" />';
            echo '<label>Link Address</label><input type="text" id="EntryCategoryMenuItem' . $i . 'OtherLink" name="data[EntryCategoryMenuItem][' . $i . '][other_link]" value="' . $this->data['EntryCategoryMenuItem'][$i]['other_link'] . '" style="width:300px;" />';
            echo '</div>';
            echo '</div>';
            echo '</li>';
        }

    }

    echo '</ul>';
    echo '</div>';

    echo '<div class="informational_box">';
    echo '<h1>&#9872;</h1><b>Category Menus</b> appear when you move your mouse over one of the navigation categories at the top of your website (on the homepage, entries, etc.)<br /><br />You can reorder category menu items by simply clicking on an item and dragging it up or down in the list.';
    echo '<br /><br />';
    echo 'Once saved, this list will look something like this: <br /><br />';
    echo '<b>Label</b><br />';
    echo '&nbsp;&nbsp;&nbsp;Link<br />';
    echo '&nbsp;&nbsp;&nbsp;Link<br />';
    echo '&nbsp;&nbsp;&nbsp;Link<br />';
    echo '<b>Label</b><br />';
    echo '&nbsp;&nbsp;&nbsp;Link<br />';
    echo '<br /><br />';
    echo 'Note: If you need to use a link that is not in the list of entries provided in the select box, just click on the "Have another link to use?" link below the select box.  It allows you to copy and paste in the link you would like to use.  Make sure to add a title for the link as well.';
    echo '</div>';
    echo '</li>';

    echo '<li id="category_li_4">';
    echo '<h3>Category Widget</h3>';
    echo '<div class="side_of_informational_box">';
    echo '<label>Widget Type</label>';
    echo $form->select('EntryCategory.widget_type', $entry_category_widgets, $this->data['EntryCategory']['widget_type'], array('style' => '', 'h3' => false));
    echo '</div>';
    echo '<div class="informational_box">';
    echo '<h1>&#9872;</h1>The <b>Category Widget</b> is a way to include different types of information for your category.  For example, if you need to include staff information in a quick-reference, list form you would use a widget to do that.'; 
    echo '<br /><br />';
    echo 'Widget preferences can be found under the <b>Preferences</b> menu at the top of this page.';
    echo '</div>';
    echo '</li>';


    echo '</ul>';   
    echo '</div>';

    echo $form->input('EntryCategory.id', array('type'=>'hidden'));

?>
</div>


</div>
<!--<input type="hidden" id="add_label_temporary_id_count" value="0" />-->
<input type="hidden" id="delete_these_labels" name="delete_these_labels" />

<input type="hidden" id="add_link_temporary_id_count" value="<?php echo $highest_menu_item_id ?>" />
<input type="hidden" id="delete_these_links" name="delete_these_links" />

<?php
    echo $form->end();
?>

<!-- dummy items for when no other items exist yet... -->
<div id="dummy_item_add_label">
    <?php echo $dummy_item_add_label; ?>
</div>

<div id="dummy_item_add_link">
    <?php echo $dummy_item_add_link; ?>
</div>

<a name="page_bottom"></a>

