<div id="list_box">
<h3><a href="<?php echo $website_calendar_link ?>">Calendar Events</a></h3>
<ul>
<?php

    for ($i=0; $i<count($calendar_events->get('entry')) - 1; $i++) {
        if ($calendar_events->get("entry[$i]")->get('link[0]')->first('@href'))
            echo '<li><a href="' . $calendar_events->get("entry[$i]")->get('link[0]')->first('@href') . '&ctz=' . date_default_timezone_get() . '">';
        else
            echo '<li><a href="">';
        echo $calendar_events->get("entry[$i]")->get('title') . '</a><br />';
        
        $event_time = preg_replace("/\<br\>(.*)/", "", $calendar_events->get("entry[$i]")->get('summary'));
        $event_time = str_replace('When: ', '', $event_time);

        echo '<span class="welcome_box_datestamp">' . $event_time . '</span>';
        echo '</li>';

        //echo '<li><a href="">' . $calendar_event['Entry']['subject'] . '</a></li>';
    }

?>
</ul>
</div>
