<?php
    echo $form->create('MiniMenu', array('action' => 'edit', 'type' => 'file'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save', array('type' => 'submit', 'name' => 'save', 'value' => '1'));
?>
</span>
<h1><?php echo $html->link('Mini Menus', '/mini_menus'); ?> &rsaquo; Edit</h1>
&uarr;<?php echo $html->link('Return to Top', '/' . $this->params['url']['url'] . '#', array('id' => 'page_top_link')); ?>
&nbsp;&nbsp;&nbsp;
</div>
<div id="single_column">
<?php
    echo '<h3>Mini Menu Details</h3>';
    echo '<label>Mini Menu Name</label>';
    echo $form->input('MiniMenu.name', array('style' => 'width:300px;', 'h3' => false, 'label' => false));

    echo '<div class="big_list_boxes">';
    echo '<ul>';

    echo '<li id="category_li_3" style="display:block;">';
    echo '<h3>Mini Menu</h3>';
    echo '<div id="entry_category_menu" class="side_of_informational_box">';

    echo '<div style="font-size:small;padding:10px;padding-left:0;">';
    echo $html->link('+ Add Link', '/' . $this->params['url']['url'] . '#add_link', array('id' => 'add_entry_category_link'));
    echo '</div>';

    echo '<ul class="sortable menu_edit_box">';

    //foreach ($this->data['MiniMenuItem'] as $menu_item) {
    for ($i = 0; $i < count($this->data['MiniMenuItem']); $i++) {

        if ($this->data['MiniMenuItem'][$i]['item_type'] == 1) {
            echo '<li id="ecl_' . $this->data['MiniMenuItem'][$i]['id'] . '" class="menu_label" style="background-color:#aaa;">';
            echo '<div style="float:right;">' . $html->link('Delete', '/' . $this->params['url']['url'] . '#delete_item', array('class' => 'delete_label ' . $this->data['MiniMenuItem'][$i]['id'], 'style' => 'font-size:small;')) . '</div>';
            echo '<div style="padding:10px;padding-top:0;">';
            echo '<label>Label</label>';
            echo '<input type="text" id="MiniMenuItem' . $i . 'Title" name="data[MiniMenuItem][' . $i . '][title]" value="' . $this->data['MiniMenuItem'][$i]['title'] . '" />';
            echo '<input type="hidden" id="MiniMenuItem' . $i . 'ItemType" name="data[MiniMenuItem][' . $i . '][item_type]" value="' . $this->data['MiniMenuItem'][$i]['item_type'] . '" />';
            echo '<input type="hidden" id="MiniMenuItem' . $i . 'Weight" name="data[MiniMenuItem][' . $i . '][weight]" value="' . $this->data['MiniMenuItem'][$i]['weight'] . '" />';
            echo '<input type="hidden" id="MiniMenuItem' . $i . 'Id" name="data[MiniMenuItem][' . $i . '][id]" value="' . $this->data['MiniMenuItem'][$i]['id'] . '" />';
            echo '</div>';
            echo '</li>';
        } else {
            echo '<li id="ecl_' . $this->data['MiniMenuItem'][$i]['id'] . '" class="menu_link">';
            echo '<div style="float:right;">' . $html->link('Delete', '/' . $this->params['url']['url'] . '#delete_item', array('class' => 'delete_link ' . $this->data['MiniMenuItem'][$i]['id'], 'style' => 'font-size:small;')) . '</div>';
            echo '<div style="padding:10px;padding-top:0;">';
            echo '<input type="hidden" id="MiniMenuItem' . $i . 'ItemType" name="data[MiniMenuItem][' . $i . '][item_type]" value="' . $this->data['MiniMenuItem'][$i]['item_type'] . '" />';
            echo '<input type="hidden" id="MiniMenuItem' . $i . 'Weight" name="data[MiniMenuItem][' . $i . '][weight]" value="' . $this->data['MiniMenuItem'][$i]['weight'] . '" />';
            echo '<input type="hidden" id="MiniMenuItem' . $i . 'Id" name="data[MiniMenuItem][' . $i . '][id]" value="' . $this->data['MiniMenuItem'][$i]['id'] . '" />';
            echo '<div style="padding-top:10px;font-size:x-small;">';
            //<a href="' . $this->params['url']['url'] . '#have_another_link_to_use" class="have_another_link_to_use">Have another link to use?</a>
            echo '</div>';

        /*
            if ($this->data['MiniMenuItem'][$i]['other_link'])
                echo '<div class="category_menu_other_link_box" style="display:block;">';
            else
                echo '<div class="category_menu_other_link_box">';
        */
            echo '<div class="category_menu_other_link_box" style="display:block;">';

            echo '<label>Link Text</label><input type="text" id="MiniMenuItem' . $i . 'OtherLinkText" name="data[MiniMenuItem][' . $i . '][other_link_text]" value="' . $this->data['MiniMenuItem'][$i]['other_link_text'] . '" style="width:300px;" />';
            echo '<label>Link Address</label><input type="text" id="MiniMenuItem' . $i . 'OtherLink" name="data[MiniMenuItem][' . $i . '][other_link]" value="' . $this->data['MiniMenuItem'][$i]['other_link'] . '" style="width:300px;" />';
            echo '</div>';
            echo '</div>';
            echo '</li>';
        }

    }

    echo '</ul>';
    echo '</div>';

    echo '<div class="informational_box">';
    echo '<h1>&#9872;</h1><b>Mini Menus</b> appear when you move your mouse over one of the links at the very top of your website\'s homepage)<br /><br />You can reorder mini menu items by simply clicking on an item and dragging it up or down in the list.';
    echo '<br /><br />';
    echo 'Once saved, this list will look something like this: <br /><br />';
    echo '&nbsp;&nbsp;&nbsp;Link<br />';
    echo '&nbsp;&nbsp;&nbsp;Link<br />';
    echo '&nbsp;&nbsp;&nbsp;Link<br />';
    echo '<br />';
    echo '</div>';
    echo '</li>';


    echo '</ul>';   
    echo '</div>';

    echo $form->input('MiniMenu.id', array('type'=>'hidden'));

?>
</div>


</div>
<input type="hidden" id="add_label_temporary_id_count" value="0" />
<input type="hidden" id="delete_these_labels" name="delete_these_labels" />

<input type="hidden" id="add_link_temporary_id_count" value="0" />
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

