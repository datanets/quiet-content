<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            ?>
            <ul>
            <?php

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <li><a href="#<?php echo preg_replace("/[^\w]+/", "_", $item['children'][$i]['EntryCategory']['name']) ?>" class="category_link"><?php echo $item['children'][$i]['EntryCategory']['name'] ?></a>
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

<div id="side_nav">

<?php for ($i=0; $i<count($categories); $i++) : ?>
    <ul>
    <li><a href="#<?php echo preg_replace("/[^\w]+/", "_", $categories[$i]['EntryCategory']['name']) ?>" class="category_link"><?php echo $categories[$i]['EntryCategory']['name'] ?></a>
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

<div id="category_featured_entries_box">
<h2>Featured Entries</h2>
<ul>
<?php

    foreach($featured as $entry) {

        //if ($entry['featured_entry']) {

            echo '<li>';
?>
<div class="actions">
    <ul>
        <li><b>Actions:</b></li>
        <li><a href="<?php echo $site_base_url ?>home/indoors">Admin Home</a> </li>
        <li><a href="<?php echo $site_base_url ?>entries/create">New Entry</a> </li>
        <li><a href="<?php echo $site_base_url ?>entries/edit/<?php echo $entry['id'] ?>">Edit Entry</a> </li>
        <li><a href="<?php echo $site_base_url ?>entries/remove/<?php echo $entry['id'] ?>" onclick="return confirm(&#039;Are you 
sure you want to delete this entry?&#039;);">Delete Entry</a> </li>
        <li><a href="<?php echo $site_base_url ?>users/logout">Logout</a> </li>
    </ul>
</div>
<?php
            echo '<h3><a href="' . $site_base_url . 'entries/' . $entry['id'] . '">' . $entry['subject'] . '</a></h3>';
            if ($entry['splash_image'] > '')
                echo '<a href="' . $site_base_url . 'entries/' . $entry['id'] . '"><img src="' . $splash_images_base_url . $entry['splash_image'] . '" /></a>';
            if ($entry['entry'] > '')
                echo substr(strip_tags($entry['entry']), 0, 300) . ' ... ';
            echo '<div class="click_here_link"><a href="' . $site_base_url . 'entries/' . $entry['id'] . '">Click here to read more!</a></div>';
            echo '<br style="clear:both;" />';
            echo '</li>';

        //}

    }

?>
</ul>
</div>

</div>

</div>
