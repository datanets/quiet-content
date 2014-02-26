<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            ?>
            <ul>
            <?php

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <li id="side_nav_<?php echo $item['children'][$i]['AdCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $item['children'][$i]['AdCategory']['name']) ?>" class="category_link"><?php echo $item['children'][$i]['AdCategory']['name'] ?></a>
            <?php

                if (count($item['children'][$i]['Ad'] > 0)) {

            ?>
                    <ul>
                    <?php

                    foreach($item['children'][$i]['Ad'] as $list_ad) :

                        $subject = $list_ad['subject'];
                        if ($subject == '')
                            $subject = 'Untitled Ad';

                        echo '<li id="side_nav_' . $list_ad['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'ads/' . $list_ad['id'] . '">' . $subject . '</a></li>';

                    endforeach;

                    
                    ?>
                    </ul>
            <?php

                }

                if (isset($item['children'][$i]['children']) && count($item['children'][$i]['children']) > 0) {
                    list_children($item['children'][$i], $site_base_url);
                }
            ?>
            </li>
            <?php

            endfor;

            ?>
            </ul>
            <?php

        }

    }

?>

<div id="single_page">

<div id="side_nav">

<?php for ($i=0; $i<count($categories); $i++) : ?>
    <ul>
    <li id="side_nav_<?php echo $categories[$i]['AdCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $categories[$i]['AdCategory']['name']) ?>" class="category_link"><?php echo $categories[$i]['AdCategory']['name'] ?></a>
    <?php

         if (count($categories[$i]['Ad'] > 0)) {

    ?>
            <ul>
            <?php

            foreach($categories[$i]['Ad'] as $list_ad) :

                $subject = $list_ad['subject'];
                if ($subject == '')
                    $subject = 'Untitled Ad';

                echo '<li id="side_nav_' . $list_ad['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'ads/' . $list_ad['id'] . '">' . $subject . '</a></li>';

            endforeach;

            
            ?>
            </ul>
    <?php

        }

    ?>
    <?php list_children($categories[$i], $site_base_url); ?>
    </li>
    </ul>
<?php endfor; ?>

</div>
<div id="page_entry">

<div class="actions">
    <ul>
        <li><b>Actions:</b></li>
        <li><a href="<?php echo $site_base_url ?>home/indoors">Admin Home</a> </li>
        <li><a href="<?php echo $site_base_url ?>ads/create">New Ad</a> </li>
        <li><a href="<?php echo $site_base_url ?>ads/edit/<?php echo $ad['Ad']['id'] ?>">Edit Ad</a> </li>
        <li><a href="<?php echo $site_base_url ?>ads/remove/<?php echo $ad['Ad']['id'] ?>" onclick="return confirm(&#039;Are you sure you want to delete this ad?&#039;);">Delete Ad</a> </li>
        <li><a href="<?php echo $site_base_url ?>users/logout">Logout</a> </li>
    </ul>
</div>


<h2><?php echo $ad['Ad']['subject']; ?></h2>
<div id="story_date_box">
<ul>
<?php

$date_created = strtotime($ad['Ad']['created']);
$date_modified = strtotime($ad['Ad']['modified']);

echo '<li>Published: ' . date("F d, Y", $date_created) . ' by ';
if ($ad['Ad']['author_created'] > '')
    echo '<a href="mailto:' . $users[$ad['Ad']['author_created']]['email'] . '">' . $users[$ad['Ad']['author_created']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';
echo '<li>Updated: ' . date("F d, Y", $date_modified) . ' by ';
if ($ad['Ad']['author_modified'] > '')
    echo '<a href="mailto:' . $users[$ad['Ad']['author_modified']]['email'] . '">' . $users[$ad['Ad']['author_modified']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';

?>
</ul>
</div>
<?php if (isset($ad['Ad']['splash_image']) && $ad['Ad']['splash_image']) : ?>
<div id="single_page_splash_image">
<a href="<?php echo $splash_images_base_url . $ad['Ad']['splash_image'] ?>" rel="prettyPhoto[images]"><img src="<?php echo $splash_images_base_url . $ad['Ad']['splash_image']; ?>" /></a>
</div>
<?php endif; ?>
<?php echo $ad['Ad']['entry']; ?>

<br style="clear:both;" />
<?php
    if (isset($ad['AdImage']) && count($ad['AdImage']) > 0) :
?>
<div id="view_image_box">
<a name="images"></a>
<h3>Images</h3>
<?php

    foreach($ad['AdImage'] as $image) {

        echo '<a href="' . $ad_images_base_url . $image['name'] . '" rel="prettyPhoto[images]"><img src="' . $ad_images_base_url . $image['name'] . '" /></a>';

    }

?>
</div>
<?php
    endif;

    if (isset($ad['AdAttachment']) && count($ad['AdAttachment']) > 0) :
?>
<div id="view_attachment_box">
<a name="attachments"></a>
<h3>Attachments</h3>
<?php

    echo '<ul>';
    foreach($ad['AdAttachment'] as $attachment) {

        echo '<li>';
        echo '<span style="float:right;font-size:x-small;">&#9906;&nbsp;<a href="' . $ad_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[attachments_a]">Preview</a>&nbsp;&nbsp;&nbsp;&#11015;&nbsp;<a href="' . $ad_attachments_base_url . $attachment['name'] . '">Download</a></span>';
        echo '<a href="' . $ad_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[attachments_b]" /><img src="' . $site_base_url . 'img/file_16.gif" /></a><a href="' . $ad_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[attachments_c]" />' . $attachment['name'] . '</a>';
        echo '</li>';

    }
    echo '</ul>';

?>
</div>
<?php
    endif;
?>

</div>


</div>

<?php
echo '<input type="hidden" id="current_id" value="' . $current_id . '" />';
echo '<input type="hidden" id="parents_path" value="' . $parents_path . '" />';
?>
