<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            ?>
            <ul>
            <?php

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <li id="side_nav_<?php echo $item['children'][$i]['EntryCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $item['children'][$i]['EntryCategory']['name']) ?>" class="category_link"><?php echo $item['children'][$i]['EntryCategory']['name'] ?></a>
            <?php

                if (count($item['children'][$i]['Entry'] > 0)) {

            ?>
                    <ul>
                    <?php

                    foreach($item['children'][$i]['Entry'] as $list_entry) :

                        $subject = $list_entry['subject'];
                        if ($subject == '')
                            $subject = 'Untitled Entry';


                        // check if this is an external link...
                        if ($list_entry['link']) {
                        
                            $link_text = '';
                            if ($list_entry['link_text'] > '')
                                $link_text = $list_entry['link_text'];
                            else
                                $link_text = $list_entry['subject'];
                    
                            echo '<li id="side_nav_' . $list_entry['id'] . '" class="side_nav_item"><span class="extra_small_icon">&#10064;</span><a href="' . $list_entry['link_address'] . '" target="_blank">' . $link_text . '</a></li>';

                        } else {
                            echo '<li id="side_nav_' . $list_entry['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'entries/' . $list_entry['id'] . '">' . $subject . '</a></li>';

                        }


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

<?php if ($entry['Entry']['blank_page']) : ?>

    <!-- This is a blank page... //-->

<?php else : ?>

<div id="side_nav">

<?php for ($i=0; $i<count($categories); $i++) : ?>
    <ul>
    <li id="side_nav_<?php echo $categories[$i]['EntryCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $categories[$i]['EntryCategory']['name']) ?>" class="category_link"><?php echo $categories[$i]['EntryCategory']['name'] ?></a>
    <?php

         if (count($categories[$i]['Entry'] > 0)) {

    ?>
            <ul>
            <?php

            foreach($categories[$i]['Entry'] as $list_entry) :

                $subject = $list_entry['subject'];
                if ($subject == '')
                    $subject = 'Untitled Entry';


                // check if this is an external link...
                if ($list_entry['link']) {

                    $link_text = '';
                    if ($list_entry['link_text'] > '')
                        $link_text = $list_entry['link_text'];
                    else
                        $link_text = $list_entry['subject'];

                    echo '<li id="side_nav_' . $list_entry['id'] . '" class="side_nav_item"><span class="extra_small_icon">&#10064;</span><a href="' . $list_entry['link_address'] . '" target="_blank">' . $link_text . '</a></li>';

                } else {

                    echo '<li id="side_nav_' . $list_entry['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'entries/' . $list_entry['id'] . '">' . $subject . '</a></li>';

                }

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
<?php
    endif;  // check for blank page
?>

<div class="actions">
	<ul>
        <li><b>Actions:</b></li>
        <li><a href="<?php echo $site_base_url ?>home/indoors">Admin Home</a> </li>
        <li><a href="<?php echo $site_base_url ?>entries/create">New Entry</a> </li>
        <li><a href="<?php echo $site_base_url ?>entries/edit/<?php echo $entry['Entry']['id'] ?>">Edit Entry</a> </li>
        <li><a href="<?php echo $site_base_url ?>entries/remove/<?php echo $entry['Entry']['id'] ?>" onclick="return confirm(&#039;Are you sure you want to delete this entry?&#039;);">Delete Entry</a> </li>
        <li><a href="<?php echo $site_base_url ?>users/logout">Logout</a> </li>
	</ul>
</div>


<h2><?php echo $entry['Entry']['subject']; ?></h2>
<div id="story_date_box">
<ul>
<?php

$date_created = strtotime($entry['Entry']['created']);
$date_modified = strtotime($entry['Entry']['modified']);

echo '<li>Published: ' . date("F d, Y", $date_created) . ' by ';
if ($entry['Entry']['author_created'] > '')
    echo '<a href="mailto:' . $users[$entry['Entry']['author_created']]['email'] . '">' . $users[$entry['Entry']['author_created']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';
echo '<li>Updated: ' . date("F d, Y", $date_modified) . ' by ';
if ($entry['Entry']['author_modified'] > '')
    echo '<a href="mailto:' . $users[$entry['Entry']['author_modified']]['email'] . '">' . $users[$entry['Entry']['author_modified']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';

?>
</ul>
</div>
<?php if (isset($entry['Entry']['splash_image']) && $entry['Entry']['splash_image']) : ?>
<div id="single_page_splash_image">
<a href="<?php echo $splash_images_base_url . $entry['Entry']['splash_image'] ?>" rel="prettyPhoto[images]"><img src="<?php echo $splash_images_base_url . $entry['Entry']['splash_image']; ?>" /></a>
</div>
<?php endif; ?>
<?php echo $entry['Entry']['entry']; ?>

<br style="clear:both;" />
<?php
    if (isset($entry['EntryImage']) && count($entry['EntryImage']) > 0) :
?>
<div id="view_image_box">
<a name="images"></a>
<h3>Images</h3>
<?php

    foreach($entry['EntryImage'] as $image) {

        echo '<a href="' . $entry_images_base_url . $image['name'] . '" rel="prettyPhoto[images]"><img src="' . $entry_images_base_url . $image['name'] . '" /></a>';

    }

?>
</div>
<?php
    endif;

    if (isset($entry['EntryAttachment']) && count($entry['EntryAttachment']) > 0) :
?>
<div id="view_attachment_box">
<a name="attachments"></a>
<h3>Attachments</h3>
<?php

    echo '<ul>';
    foreach($entry['EntryAttachment'] as $attachment) {

        echo '<li>';
        echo '<span style="float:right;font-size:x-small;">';
        if (isPicture($entry_attachments_base_url . $attachment['name']))
            echo '&#9906;&nbsp;<a href="' . $entry_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[entry_a]">Preview</a>&nbsp;&nbsp;&nbsp;';
        echo '&#11015;&nbsp;<a href="' . $entry_attachments_base_url . $attachment['name'] . '">Download</a>';
        echo '</span>';
        if (isPicture($entry_attachments_base_url . $attachment['name'])) 
            echo '<a href="' . $entry_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[entry_b]" /><img src="' . $site_base_url . 'img/file_16.gif" /></a><a href="' . $entry_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[entry_c]" />' . $attachment['name'] . '</a>';
        else
            echo '<img src="' . $site_base_url . 'img/file_16.gif" />' . $attachment['name'];
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
