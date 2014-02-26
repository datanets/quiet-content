<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            ?>
            <ul>
            <?php

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <li><a href="#<?php echo preg_replace("/[^\w]+/", "_", $item['children'][$i]['AdCategory']['name']) ?>" class="category_link"><?php echo $item['children'][$i]['AdCategory']['name'] ?></a>
            <?php

                if (count($item['children'][$i]['Ad'] > 0)) {

            ?>
                    <ul>
                    <?php

                    foreach($item['children'][$i]['Ad'] as $list_ad) :

                        $subject = $list_ad['subject'];
                        if ($subject == '')
                            $subject = 'Untitled Ad';

                        echo '<li class="side_nav_item"><a href="' . $site_base_url . 'ads/view/' . $list_ad['id'] . '">' . $subject . '</a></li>';

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
    <li><a href="#<?php echo preg_replace("/[^\w]+/", "_", $categories[$i]['AdCategory']['name']) ?>" class="category_link"><?php echo $categories[$i]['AdCategory']['name'] ?></a>
    <?php

         if (count($categories[$i]['Ad'] > 0)) {

    ?>
            <ul>
            <?php

            foreach($categories[$i]['Ad'] as $list_ad) :

                $subject = $list_ad['subject'];
                if ($subject == '')
                    $subject = 'Untitled Ad';

                echo '<li class="side_nav_item"><a href="' . $site_base_url . 'ads/view/' . $list_ad['id'] . '">' . $subject . '</a></li>';

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
<div id="page_ad">

<div id="category_featured_ads_box">
<h2>Featured Ads</h2>
<ul>
<?php

    for ($j = 0; $j < count($categories); $j++) {

        foreach($categories[$j]['Ad'] as $ad) {

            if ($ad['featured_ad']) {

                echo '<li>';
?>
<div class="actions">
    <ul>
        <li><b>Actions:</b></li>
        <li><a href="<?php echo $site_base_url ?>home/indoors">Admin Home</a> </li>
        <li><a href="<?php echo $site_base_url ?>ads/create">New Ad</a> </li>
        <li><a href="<?php echo $site_base_url ?>ads/edit/<?php echo $ad['id'] ?>">Edit Ad</a> </li>
        <li><a href="<?php echo $site_base_url ?>ads/remove/<?php echo $ad['id'] ?>" onclick="return confirm(&#039;Are you sure you want to delete this ad?&#039;);">Delete Ad</a> </li>
        <li><a href="<?php echo $site_base_url ?>users/logout">Logout</a> </li>
    </ul>
</div>
<?php
                echo '<h3>' . $ad['subject'] . '</h3>';
                if ($ad['splash_image'] > '')
                    echo '<a href="' . $site_base_url . 'ads/' . $ad['id'] . '"><img src="' . $splash_images_base_url . $ad['splash_image'] . '" /></a>';
                if ($ad['ad'] > '')
                    echo substr(strip_tags($ad['ad']), 0, 300) . ' ... ';
                echo '<div class="click_here_link"><a href="' . $site_base_url . 'ads/' . $ad['id'] . '">Click here to read more!</a></div>';
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
