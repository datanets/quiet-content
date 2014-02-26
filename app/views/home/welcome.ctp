<div id="box_rows">
<ul>
<li>
<div id="splash_news_story_box">
<?php

    if (isset($splash_news[0])) {

        //echo '<img src="' . $splash_images_base_url . $splash_news[0]['News']['splash_image'] . '" style="width:280px;">';
        //echo '<div style="width:560px;height:170px;background: url(' . $splash_images_base_url . $splash_news[0]['News']['splash_image'] . ') center;"></div>';

        if (isset($splash_news[0]['News']['splash_image']) && $splash_news[0]['News']['splash_image'] > '') {
            echo '<a href="' . $site_base_url . 'news/' . $splash_news[0]['News']['id'] . '"><span class="splash_image_link" style="background: #ffffff url(\'' . $splash_images_base_url . $splash_news[0]['News']['splash_image'] . '\') ' . $splash_news[0]['News']['splash_image_align'] . ';"></span></a>';

        }
        echo '<h2>' . $html->link($splash_news[0]['News']['subject'], '/news/' . $splash_news[0]['News']['id']) . '</h2>';
        echo '<p>';
        //echo strip_tags(preg_replace('/\s+?(\S+)?$/', '', substr($splash_news[0]['News']['entry'], 0, 1500)), '<a><br>');
        #echo strip_tags(substr($splash_news[0]['News']['entry'], 0, 1500), '<a><br>');

        $read_more_link = strpos($splash_news[0]['News']['entry'], '[read-more]');
        if (intval($read_more_link) > 0) {
            echo strip_tags(substr($splash_news[0]['News']['entry'], 0, $read_more_link), '<a><b><br>');
        } else {
            echo strip_tags(substr($splash_news[0]['News']['entry'], 0, 1500), '<a><b><br>');
        }

        if (strlen($splash_news[0]['News']['entry']) > 1500)
            echo ' ...<div class="read_more_link">' . $html->link('(Click here to continue reading...)', '/news/' . $splash_news[0]['News']['id']) . '</div>';
        echo '</p>';

    }
?>
<div class="news_archive_link_box">&#9776;&nbsp;<a href="<?php echo $site_base_url ?>news/archive"">Click here to visit the News Archives...</a></div>
</div>
</li>
<li>
<div id="twitter_box" class="welcome_side_box"></div>
</li>
<li>
<div id="announcements_box" class="welcome_side_box">
<div class="welcome_side_box_header">
<!--<div class="welcome_side_box_avatar"><!--&#9888--&#9776;</div>-->
<div class="welcome_side_box_avatar"><div id="announcements_icon"><span id="announcements_icon_content">&nbsp;A&nbsp;</span></div></div>
<h2>Announcements</h2>
</div>
<ul>
<?php

    foreach($announcements as $announcement) {

        $announcement_date = strtotime($announcement['Announcement']['modified']);

        echo '<li><p>' . $html->link($announcement['Announcement']['subject'], '/announcements/' . $announcement['Announcement']['id']) . '<br /><span class="welcome_side_box_datestamp">Updated on ' . date("F d, Y", $announcement_date) . '</span></p></li>';
    }

?>
</ul>
</div>
<br style="clear:both;" />
<br />
<div id="calendar_events_box" class="welcome_side_box">
<div class="welcome_side_box_header">
<div class="welcome_side_box_avatar"><div id="calendar_icon"><a href="<?php echo $website_calendar_link ?>"><span id="calendar_icon_month">Jan</span><span id="calendar_icon_day">&nbsp;1&nbsp;</span></a></div></div>
<h2><a href="<?php echo $website_calendar_link ?>">Calendar Events</a></h2>
</div>
<ul>
<?php

    for ($i=0; $i<count($calendar_events->get('entry')) - 1; $i++) {
        if ($calendar_events->get("entry[$i]")->get('link[0]')->first('@href'))
            echo '<li><p><a href="' . $calendar_events->get("entry[$i]")->get('link[0]')->first('@href') . '&ctz=' . date_default_timezone_get() . '">';
        else
            echo '<li><p><a href="">';
        echo $calendar_events->get("entry[$i]")->get('title') . '</a><br />';
        
        $event_time = preg_replace("/\<br\>(.*)/", "", $calendar_events->get("entry[$i]")->get('summary'));
        $event_time = str_replace('When: ', '', $event_time);

        echo '<span class="welcome_side_box_datestamp">' . fix_google_calendar_feed($event_time) . '</span>';
        echo '</p></li>';

        //echo '<li><a href="">' . $calendar_event['Entry']['subject'] . '</a></li>';
    }

?>
</ul>


<?php
/*
    for ($i=0; $i<count($calendar_events->get('entry')) - 1; $i++) {
        //debug($calendar_events->get("entry[$i]"));
        //debug($calendar_events->get("entry[$i]")->get('link[0]'));

        $temp = $calendar_events->get("entry[$i]")->get('link[0]')->get('@href');
        debug($temp);

        //echo $calendar_events->get("entry[$i]")->get('link[0]')->get('href');
    }
*/
?>
</div>
</li>
</ul>
</div>
<br style="clear:both;" />

<?php

if (isset($featured_entries) && count($featured_entries) > 0) {

?>
<div id="featured_entries_box">
<div class="featured_entries_title">Featured Entries</div>
<ul>
<?php

foreach($featured_entries as $featured_entry) :

?>
<li>
<?php
    $link = ""; 
    if ($featured_entry['Entry']['link'])
      $link = $featured_entry['Entry']['link_address'];
    else
      $link = $site_base_url . 'entries/' . $featured_entry['Entry']['id'];

    if (isset($featured_entry['Entry']['splash_image']) && $featured_entry['Entry']['splash_image'] > '') {
        echo '<a href="' . $link . '"><span class="featured_entry_splash_image_link" style="background: #999999 url(\'' . $splash_images_base_url . $featured_entry['Entry']['splash_image'] . '\') top right;"><span class="featured_entries_header"><p>' . $featured_entry['Entry']['subject'] . '</p></span></span></a>';
    } else {
        echo '<a href="' . $link . '"><span class="featured_entry_splash_image_link" style="background: #999999 url(\'' . $site_base_url . 'img/grey_block.png' . '\') top right;"><span class="featured_entries_header"><p>' . $featured_entry['Entry']['subject'] . '</p></span></span></a>';
    }
?>
</li>
<?php

endforeach;

?>
</ul>
</div>
<?php

}

?>
