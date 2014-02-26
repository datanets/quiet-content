<?php
    echo $form->create('AdCategory', array('action' => 'index'));
?>

<div id="content_heading">

<h1>Ad Categories</h1>
<?php echo $html->link('+ New Category', '/ad_categories/create', array('id' => 'add_category')); ?>
</div>


<div id="single_column">

<div id="sortable_tree_box">
<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <ul class="sortable_tree connectedSortable">
            <li id="item_<?php echo $item['children'][$i]['AdCategory']['id']; ?>"><?php

                    echo '<p>' . $item['children'][$i]['AdCategory']['name'] . '</p>';
                    echo '<div class="category_options"><a href="ad_categories#rename" class="rename_category">Rename</a> | <a href="' . $site_base_url . 'ad_categories/delete/' . $item['children'][$i]['AdCategory']['id'] . '" class="delete_category">Delete</a></div>';

                ?>
                <ul class="sortable_tree connectedSortable">
                    <li class="folder_place_holder"></li>
                    <li>
                    <?php
                        if (isset($item['children'][$i]['children']) && $item['children'][$i]['children']) {
                            list_children($item['children'][$i], $site_base_url);
                        }
                    ?>
                    </li>
                </ul>
            </li>
            </ul>
            <?php

            endfor;

        }

    }

?>

<?php for ($i=0; $i<count($categories); $i++) : ?>

    <ul class="sortable_tree connectedSortable">
    <li id="item_<?php echo $categories[$i]['AdCategory']['id']; ?>"><?php

            echo '<div id="category_root">' . $categories[$i]['AdCategory']['name'] . '</div>';
        ?>
            <?php list_children($categories[$i], $site_base_url); ?>
    </li>
    </ul>
<?php endfor; ?>


</div>

<?php
    echo $form->end();
?>

<form name="url_information_for_javascript">
<input type="hidden" id="site_base_url" value="<?php echo $site_base_url; ?>" />
<input type="hidden" id="ajax_action_url" value="<?php echo $this->params['url']['url']; ?>" />
</form>
