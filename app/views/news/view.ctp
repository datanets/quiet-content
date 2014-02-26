<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            ?>
            <ul>
            <?php

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <li id="side_nav_<?php echo $item['children'][$i]['NewsCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $item['children'][$i]['NewsCategory']['name']) ?>" class="category_link"><?php echo $item['children'][$i]['NewsCategory']['name'] ?></a>
            <?php

                if (count($item['children'][$i]['News'] > 0)) {

            ?>
                    <ul>
                    <?php

                    foreach($item['children'][$i]['News'] as $list_news) :

                        $subject = $list_news['subject'];
                        if ($subject == '')
                            $subject = 'Untitled News';

                        echo '<li id="side_nav_' . $list_news['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'news/' . $list_news['id'] . '">' . $subject . '</a></li>';

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
<ul>
<?php for ($i=0; $i<count($categories); $i++) : ?>
    <li id="side_nav_<?php echo $categories[$i]['NewsCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $categories[$i]['NewsCategory']['name']) ?>" class="category_link"><?php echo $categories[$i]['NewsCategory']['name'] ?></a>
    <?php

         if (count($categories[$i]['News'] > 0)) {

    ?>
            <ul>
            <?php

            foreach($categories[$i]['News'] as $list_news) :

                $subject = $list_news['subject'];
                if ($subject == '')
                    $subject = 'Untitled News';

                echo '<li id="side_nav_' . $list_news['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'news/' . $list_news['id'] . '">' . $subject . '</a></li>';

            endforeach;

            
            ?>
            </ul>
    <?php

        }

    ?>
    <?php list_children($categories[$i], $site_base_url); ?>
    </li>
<?php endfor; ?>
<li><a href="<?php echo $site_base_url ?>news/archive">News Archive</a></li>
</ul>
</div>
<div id="page_entry">

<div class="actions">
    <ul>
        <li><b>Actions:</b></li>
        <li><a href="<?php echo $site_base_url ?>home/indoors">Admin Home</a> </li>
        <li><a href="<?php echo $site_base_url ?>news/create">New News</a> </li>
        <li><a href="<?php echo $site_base_url ?>news/edit/<?php echo $news['News']['id'] ?>">Edit News</a> </li>        <li><a href="<?php echo $site_base_url ?>news/remove/<?php echo $news['News']['id'] ?>" onclick="return confirm(&#039;Are you sure you want to delete this news?&#039;);">Delete News</a> </li>
        <li><a href="<?php echo $site_base_url ?>users/logout">Logout</a> </li>
    </ul>
</div>


<h2><?php echo $news['News']['subject']; ?></h2>
<div id="story_date_box">
<ul>
<?php

$date_created = strtotime($news['News']['created']);
$date_modified = strtotime($news['News']['modified']);

echo '<li>Published: ' . date("F d, Y", $date_created) . ' by ';
if ($news['News']['author_created'] > '')
    echo '<a href="mailto:' . $users[$news['News']['author_created']]['email'] . '">' . $users[$news['News']['author_created']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';
echo '<li>Updated: ' . date("F d, Y", $date_modified) . ' by ';
if ($news['News']['author_modified'] > '')
    echo '<a href="mailto:' . $users[$news['News']['author_modified']]['email'] . '">' . $users[$news['News']['author_modified']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';

?>
</ul>
</div>
<?php if (isset($news['News']['splash_image']) && $news['News']['splash_image']) : ?>
<div id="single_page_splash_image">
<a href="<?php echo $splash_images_base_url . $news['News']['splash_image'] ?>" rel="prettyPhoto[images]"><img src="<?php echo $splash_images_base_url . $news['News']['splash_image']; ?>" /></a>
</div>
<?php endif; ?>
<?php echo str_replace('[read-more]', '', $news['News']['entry']); ?>

<br style="clear:both;" />
<?php
    if (isset($news['NewsImage']) && count($news['NewsImage']) > 0) :
?>
<div id="view_image_box">
<a name="images"></a>
<h3>Images</h3>
<?php

    foreach($news['NewsImage'] as $image) {

        echo '<a href="' . $news_images_base_url . $image['name'] . '" rel="prettyPhoto[images]"><img src="' . $news_images_base_url . $image['name'] . '" /></a>';

    }

?>
</div>
<?php
    endif;

    if (isset($news['NewsAttachment']) && count($news['NewsAttachment']) > 0) :
?>
<div id="view_attachment_box">
<a name="attachments"></a>
<h3>Attachments</h3>
<?php

    echo '<ul>';
    foreach($news['NewsAttachment'] as $news) {

        echo '<li>';
        echo '<span style="float:right;font-size:x-small;">';
        if (isPicture($news_attachments_base_url . $news['name']))
            echo '&#9906;&nbsp;<a href="' . $news_attachments_base_url . $news['name'] . '" rel="prettyPhoto[news_a]">Preview</a>&nbsp;&nbsp;&nbsp;';
        echo '&#11015;&nbsp;<a href="' . $news_attachments_base_url . $news['name'] . '">Download</a>';
        echo '</span>';
        if (isPicture($news_attachments_base_url . $news['name'])) 
            echo '<a href="' . $news_attachments_base_url . $news['name'] . '" rel="prettyPhoto[news_b]" /><img src="' . $site_base_url . 'img/file_16.gif" /></a><a href="' . $news_attachments_base_url . $news['name'] . '" rel="prettyPhoto[news_c]" />' . $news['name'] . '</a>';
        else
            echo '<img src="' . $site_base_url . 'img/file_16.gif" />' . $news['name'];
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
