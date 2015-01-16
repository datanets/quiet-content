<div id="splash_news_story_box">
<?php

    if (isset($splash_news[0])) {


        if (isset($splash_news[0]['News']['splash_image']) && $splash_news[0]['News']['splash_image'] > '') {
            echo '<a href="' . $site_base_url . 'mobile/m_news/' . $splash_news[0]['News']['id'] . '"><img src="' . $splash_images_base_url . $splash_news[0]['News']['splash_image'] . '" id="splash_image"></a>';
        }
        echo '<div class="box">';
        echo '<h3>' . $html->link($splash_news[0]['News']['subject'], '/mobile/m_news/' . $splash_news[0]['News']['id']) . '</h3>';
        echo strip_tags(substr($splash_news[0]['News']['entry'], 0, 1500), '<a><br>');
        if (strlen($splash_news[0]['News']['entry']) > 1500)
            echo ' ...';
        echo '</div>';

    }
?>
</div>

