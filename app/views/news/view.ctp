<div id="single_page">

<div class="row">

<!-- panel -->
<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 col-sm-push-2 col-md-push-2 col-lg-push-2">
    <div id="page_entry">
        <div class="actions">
            <ul>
                <li><b>Actions:</b></li>
                <li><a href="<?php echo $site_base_url ?>home/indoors">Admin Home</a> </li>
                <li><a href="<?php echo $site_base_url ?>news/create">New News</a> </li>
                <li><a href="<?php echo $site_base_url ?>news/edit/<?php echo $news['News']['id'] ?>">Edit News</a> </li>
                <li><a href="<?php echo $site_base_url ?>news/remove/<?php echo $news['News']['id'] ?>" onclick="return confirm(&#039;Are you sure you want to delete this news?&#039;);">Delete News</a> </li>
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
        <a href="<?php echo $splash_images_base_url . $news['News']['splash_image'] ?>" rel="prettyPhoto[images]"><img src="<?php echo $splash_images_base_url . $news['News']['splash_image']; ?>" class="img-rounded" /></a>
        </div>
        <?php endif; ?>
        <p><?php echo $news['News']['entry']; ?></p>

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
            foreach($news['NewsAttachment'] as $attachment) {

                echo '<li>';
                echo '<span style="float:right;">';
                if (isPicture($news_attachments_base_url . $attachment['name']))
                    echo '<span class="glyphicon glyphicon-zoom-in"></span>&nbsp;<a href="' . $news_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[news_a]">Preview</a>&nbsp;&nbsp;&nbsp;';
                echo '<span class="glyphicon glyphicon-download"></span>&nbsp;<a href="' . $news_attachments_base_url . $attachment['name'] . '">Download</a>';
                echo '</span>';
                if (isPicture($news_attachments_base_url . $attachment['name'])) 
                    echo '<span class="glyphicon glyphicon-file"></span>&nbsp;<a href="' . $news_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[news_c]" />' . $attachment['name'] . '</a>';
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

    <!-- sidebar -->
    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-sm-pull-10 col-md-pull-10 col-lg-pull-10">
        <div id="side_nav">
            <ul>
            <li><a href="<?php echo $site_base_url ?>news/archive">News Archive</a></li>
            </ul>
        </div>
    </div> <!-- end of sidebar -->

</div> <!-- end of row -->

<?php
echo '<input type="hidden" id="current_id" value="' . $current_id . '" />';
echo '<input type="hidden" id="parents_path" value="' . $parents_path . '" />';
?>
