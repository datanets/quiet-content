<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            ?>
            <ul>
            <?php

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <li id="side_nav_<?php echo $item['children'][$i]['AnnouncementCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $item['children'][$i]['AnnouncementCategory']['name']) ?>" class="category_link"><?php echo $item['children'][$i]['AnnouncementCategory']['name'] ?></a>
            <?php

                if (count($item['children'][$i]['Announcement'] > 0)) {

            ?>
                    <ul>
                    <?php

                    foreach($item['children'][$i]['Announcement'] as $list_announcement) :

                        $subject = $list_announcement['subject'];
                        if ($subject == '')
                            $subject = 'Untitled Announcement';

                        echo '<li id="side_nav_' . $list_announcement['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'announcements/' . $list_announcement['id'] . '">' . $subject . '</a></li>';

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
    <li id="side_nav_<?php echo $categories[$i]['AnnouncementCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $categories[$i]['AnnouncementCategory']['name']) ?>" class="category_link"><?php echo $categories[$i]['AnnouncementCategory']['name'] ?></a>
    <?php

         if (count($categories[$i]['Announcement'] > 0)) {

    ?>
            <ul>
            <?php

            foreach($categories[$i]['Announcement'] as $list_announcement) :

                $subject = $list_announcement['subject'];
                if ($subject == '')
                    $subject = 'Untitled Announcement';

                echo '<li id="side_nav_' . $list_announcement['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'announcements/' . $list_announcement['id'] . '">' . $subject . '</a></li>';

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
        <li><a href="<?php echo $site_base_url ?>announcements/create">New Announcement</a> </li>
        <li><a href="<?php echo $site_base_url ?>announcements/edit/<?php echo $announcement['Announcement']['id'] ?>">Edit Announcement</a> </li>
        <li><a href="<?php echo $site_base_url ?>announcements/remove/<?php echo $announcement['Announcement']['id'] ?>" onclick="return confirm(&#039;Are you sure you want to delete this announcement?&#039;);">Delete Announcement</a> </li>
        <li><a href="<?php echo $site_base_url ?>users/logout">Logout</a> </li>
    </ul>
</div>


<h2><?php echo $announcement['Announcement']['subject']; ?></h2>
<div id="story_date_box">
<ul>
<?php

$date_created = strtotime($announcement['Announcement']['created']);
$date_modified = strtotime($announcement['Announcement']['modified']);

echo '<li>Published: ' . date("F d, Y", $date_created) . ' by ';
if ($announcement['Announcement']['author_created'] > '')
    echo '<a href="mailto:' . $users[$announcement['Announcement']['author_created']]['email'] . '">' . $users[$announcement['Announcement']['author_created']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';
echo '<li>Updated: ' . date("F d, Y", $date_modified) . ' by ';
if ($announcement['Announcement']['author_modified'] > '')
    echo '<a href="mailto:' . $users[$announcement['Announcement']['author_modified']]['email'] . '">' . $users[$announcement['Announcement']['author_modified']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';

?>
</ul>
</div>
<?php if (isset($announcement['Announcement']['splash_image']) && $announcement['Announcement']['splash_image']) : ?>
<div id="single_page_splash_image">
<a href="<?php echo $splash_images_base_url . $announcement['Announcement']['splash_image'] ?>" rel="prettyPhoto[images]"><img src="<?php echo $splash_images_base_url . $announcement['Announcement']['splash_image']; ?>" /></a>
</div>
<?php endif; ?>
<?php echo $announcement['Announcement']['entry']; ?>

<br style="clear:both;" />
<?php
    if (isset($announcement['AnnouncementImage']) && count($announcement['AnnouncementImage']) > 0) :
?>
<div id="view_image_box">
<a name="images"></a>
<h3>Images</h3>
<?php

    foreach($announcement['AnnouncementImage'] as $image) {

        echo '<a href="' . $announcement_images_base_url . $image['name'] . '" rel="prettyPhoto[images]"><img src="' . $announcement_images_base_url . $image['name'] . '" /></a>';

    }

?>
</div>
<?php
    endif;

    if (isset($announcement['AnnouncementAttachment']) && count($announcement['AnnouncementAttachment']) > 0) :
?>
<div id="view_attachment_box">
<a name="attachments"></a>
<h3>Attachments</h3>
<?php

    echo '<ul>';
    foreach($announcement['AnnouncementAttachment'] as $attachment) {

        echo '<li>';
        echo '<span style="float:right;font-size:x-small;">';
        if (isPicture($announcement_attachments_base_url . $attachment['name']))
            echo '&#9906;&nbsp;<a href="' . $announcement_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[announcement_a]">Preview</a>&nbsp;&nbsp;&nbsp;';
        echo '&#11015;&nbsp;<a href="' . $announcement_attachments_base_url . $attachment['name'] . '">Download</a>';
        echo '</span>';
        if (isPicture($announcement_attachments_base_url . $attachment['name'])) 
            echo '<a href="' . $announcement_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[announcement_b]" /><img src="' . $site_base_url . 'img/file_16.gif" /></a><a href="' . $announcement_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[announcement_c]" />' . $attachment['name'] . '</a>';
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
