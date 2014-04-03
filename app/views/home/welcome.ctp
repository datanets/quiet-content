<div class="row row-offcanvas row-offcanvas-right">
    <div class="col-xs-12 col-sm-6">
        <div class="jumbotron thin-jumbotron">
            <h1><?php echo $html->link($splash_news[0]['News']['subject'], '/news/' . $splash_news[0]['News']['id']); ?></h1>
            <?php echo '<a href="' . $site_base_url . 'news/' . $splash_news[0]['News']['id'] . '"><img src="' . $splash_images_base_url . $splash_news[0]['News']['splash_image'] . '" class="img-rounded img-responsive showcase-splash-image" /></a>'; ?>
            <div class="splash-news-body"><?php
                    $i = strpos($splash_news[0]['News']['entry'], '<!-- readmore -->');
                    if ($i !== false) {
                        $i += strlen('<!-- readmore -->');
                        echo substr($splash_news[0]['News']['entry'], 0, $i);
                        echo '<div class="read-more-link">' . $html->link('(Click here to continue reading...)', '/news/' . $splash_news[0]['News']['id']) . '</div>';
                    } else {
                        echo $splash_news[0]['News']['entry'];
                    }
            ?></div>
          </div>
          <div class="row">
            <div class="recent-stories">
              <h4>Recent Stories</h4>
              <?php
                  foreach (array_slice($splash_news, 1) as $news_item) {
                      echo '<div class="col-12 col-sm-12 col-lg-6">';
                      echo '<div class="cropped-image-container">';
                      echo '<p>' . $html->link($news_item['News']['subject'], '/news/' . $news_item['News']['id']) . '</p>';
                      echo '<a href="' . $site_base_url . 'news/' . $news_item['News']['id'] . '"><img src="' . $splash_images_base_url . $news_item['News']['splash_image'] . '" class="img-rounded img-responsive" /></a>';
                      echo '</div>';
                      echo '</div>';
                  }
              ?>
            </div>
        </div><!--/row-->
    </div><!--/span-->
    <div class="col-xs-12 col-sm-3">
        <div class="row featured">
            <h4>Features</h4>
            <?php

            echo '<div class="col-12 col-sm-12 col-lg-12">';

            // Ads
            foreach($current_ads as $current_ad) {

                if (isset($current_ad['Ad']['splash_image']) && $current_ad['Ad']['splash_image'] > '') {
                    echo '<span class="featured-entry-splash-image-link" style="background: #999999 url(\'' . $splash_images_base_url . $current_ad['Ad']['splash_image'] . '\') top right;"><span class="featured-ads-header"><p>' . $current_ad['Ad']['entry'] . '</p></span></span>';
                } else {
                    echo '<span class="featured-entry-splash-image-link" style="background: #999999 url(\'' . $site_base_url . 'img/grey_block.png' . '\') top right;"><span class="featured-ads-header"><p>' . $current_ad['Ad']['entry'] . '</p></span></span>';
                }
            }

            // Features
            foreach($featured_entries as $featured_entry) {

                $article_type = "Entry";
                $article_type_link = "entries";

                if (isset($featured_entry['News'])) {
                    $article_type = "News";
                    $article_type_link = "news";
                }

                $link = "";
                if ($featured_entry[$article_type]['link'])
                    $link = $featured_entry[$article_type]['link_address'];
                else
                    $link = $site_base_url . $article_type_link . '/' . $featured_entry[$article_type]['id'];

                if (isset($featured_entry[$article_type]['splash_image']) && $featured_entry[$article_type]['splash_image'] > '') {
                    echo '<a href="' . $link . '"><span class="featured-entry-splash-image-link" style="background: #999999 url(\'' . $splash_images_base_url . $featured_entry[$article_type]['splash_image'] . '\') top right;"><span class="featured-entries-header"><p>' . $featured_entry[$article_type]['subject'] . '</p></span></span></a>';
                } else {
                    echo '<a href="' . $link . '"><span class="featured-entry-splash-image-link" style="background: #999999 url(\'' . $site_base_url . 'img/grey_block.png' . '\') top right;"><span class="featured-entries-header"><p>' . $featured_entry[$article_type]['subject'] . '</p></span></span></a>';
                }
            }
            echo '</div>';
            ?>
        </div><!--/row-->
    </div><!--/span-->

    <div class="col-xs-12 col-sm-3">
        <div class="row announcements">
            <h4>Announcements</h4>
            <ul>
            <?php

                foreach($announcements as $announcement) {

                    $announcement_date = strtotime($announcement['Announcement']['modified']);

                    echo '<li><p>' . $html->link($announcement['Announcement']['subject'], '/announcements/' . $announcement['Announcement']['id']) . '<br /><span class="welcome_side_box_datestamp">Updated on ' . date("F d, Y", $announcement_date) . '</span></p></li>';
                }

            ?>
            </ul>

            <h4>Events</h4>
            <ul>
            <?php

                for ($i=0; $i<count($calendar_events->get('entry')) - 1; $i++) {
                    if ($calendar_events->get("entry[$i]")->get('link[0]')->first('@href'))
                        echo '<li><a href="' . $calendar_events->get("entry[$i]")->get('link[0]')->first('@href') . '&ctz=' . date_default_timezone_get() . '">';
                    else
                        echo '<li><p><a href="">';
                    echo $calendar_events->get("entry[$i]")->get('title') . '</a><br />';

                    $event_time = preg_replace("/\<br\>(.*)/", "", $calendar_events->get("entry[$i]")->get('summary'));
                    $event_time = str_replace('When: ', '', $event_time);

                    echo '<span class="welcome_side_box_datestamp">' . fix_google_calendar_feed($event_time) . '</span>';
                    echo '</p></li>';

                }

            ?>
            </ul>
        </div><!--/row-->
    </div><!--/span-->
</div>
