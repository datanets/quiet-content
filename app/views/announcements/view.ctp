<div id="single_page">

<div class="row">
<div id="page_announcement">
<div class="col-sm-12">
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
<a href="<?php echo $splash_images_base_url . $announcement['Announcement']['splash_image'] ?>" rel="prettyPhoto[images]"><img src="<?php echo $splash_images_base_url . $announcement['Announcement']['splash_image']; ?>" class="img-rounded" /></a>
</div>
<?php endif; ?>
<p><?php echo $announcement['Announcement']['entry']; ?></p>

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
        echo '<span style="float:right;">';
        if (isPicture($announcement_attachments_base_url . $attachment['name']))
            echo '<span class="glyphicon glyphicon-zoom-in"></span>&nbsp;<a href="' . $announcement_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[announcement_a]">Preview</a>&nbsp;&nbsp;&nbsp;';
        echo '<span class="glyphicon glyphicon-download"></span>&nbsp;<a href="' . $announcement_attachments_base_url . $attachment['name'] . '">Download</a>';
        echo '</span>';
        if (isPicture($announcement_attachments_base_url . $attachment['name'])) 
            echo '<span class="glyphicon glyphicon-file"></span>&nbsp;<a href="' . $announcement_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[announcement_c]" />' . $attachment['name'] . '</a>';
        else
            echo '<span class="glyphicon glyphicon-file"></span>&nbsp;' . $attachment['name'];
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
