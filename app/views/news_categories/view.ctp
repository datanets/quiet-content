<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            ?>
            <ul>
            <?php

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <li><a href="#<?php echo preg_replace("/[^\w]+/", "_", $item['children'][$i]['AnnouncementCategory']['name']) ?>" class="category_link"><?php echo $item['children'][$i]['AnnouncementCategory']['name'] ?></a>
            <?php

                if (count($item['children'][$i]['Announcement'] > 0)) {

            ?>
                    <ul>
                    <?php

                    foreach($item['children'][$i]['Announcement'] as $list_announcement) :

                        $subject = $list_announcement['subject'];
                        if ($subject == '')
                            $subject = 'Untitled Announcement';

                        echo '<li class="side_nav_item"><a href="' . $site_base_url . 'announcements/view/' . $list_announcement['id'] . '">' . $subject . '</a></li>';

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
    <li><a href="#<?php echo preg_replace("/[^\w]+/", "_", $categories[$i]['AnnouncementCategory']['name']) ?>" class="category_link"><?php echo $categories[$i]['AnnouncementCategory']['name'] ?></a>
    <?php

         if (count($categories[$i]['Announcement'] > 0)) {

    ?>
            <ul>
            <?php

            foreach($categories[$i]['Announcement'] as $list_announcement) :

                $subject = $list_announcement['subject'];
                if ($subject == '')
                    $subject = 'Untitled Announcement';

                echo '<li class="side_nav_item"><a href="' . $site_base_url . 'announcements/view/' . $list_announcement['id'] . '">' . $subject . '</a></li>';

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
<div id="page_announcement">

<div id="category_featured_announcements_box">
<h2>Featured Announcements</h2>
<ul>
<?php

    for ($j = 0; $j < count($categories); $j++) {

        foreach($categories[$j]['Announcement'] as $announcement) {

            if ($announcement['featured_announcement']) {

                echo '<li>';
?>
<div class="actions">
    <ul>
        <li><b>Actions:</b></li>
        <li><a href="<?php echo $site_base_url ?>home/indoors">Admin Home</a> </li>
        <li><a href="<?php echo $site_base_url ?>news/create">New News</a> </li>
        <li><a href="<?php echo $site_base_url ?>news/edit/<?php echo $news['id'] ?>">Edit News</a> </li>
        <li><a href="<?php echo $site_base_url ?>news/remove/<?php echo $news['id'] ?>" onclick="return confirm(&#039;Are you sure you want to delete this news?&#039;);">Delete News</a> </li>
        <li><a href="<?php echo $site_base_url ?>users/logout">Logout</a> </li>
    </ul>
</div>
<?php
                echo '<h3>' . $announcement['subject'] . '</h3>';
                if ($announcement['splash_image'] > '')
                    echo '<a href="' . $site_base_url . 'announcements/' . $announcement['id'] . '"><img src="' . $splash_images_base_url . $announcement['splash_image'] . '" /></a>';
                if ($announcement['announcement'] > '')
                    echo substr(strip_tags($announcement['announcement']), 0, 300) . ' ... ';
                echo '<div class="click_here_link"><a href="' . $site_base_url . 'announcements/' . $announcement['id'] . '">Click here to read more!</a></div>';
                echo '<br style="clear:both;" />';
                echo '</li>';

            }

        }

    }

?>
</ul>
</div>

</div>

</div>
