<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_for_layout?></title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>bootstrap/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/smoothness/jquery-ui-1.8.2.custom.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/prettyPhoto.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $website_theme_url . '/' . $website_preferences['Preference']['website_theme']; ?>/default.css" />
<link href="<?php echo $site_base_url; ?>bootstrap/css/bootstrap-glyphicons.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/public_main.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/respond.min.js"></script>
</head>
<body>
<div id="emergency-alerts-box">
<ul>
<script type="text/javascript">

// Emergency Alerts
jQuery(function() {

    jQuery.getFeed({
        url: '<?php echo $site_base_url; ?>emergency_alerts/feed_proxy',
        dataType: ($.browser.msie) ? "text" : "xml",
        success: function(feed) {

            if (feed.items.length > 0) {

                $('#emergency-alerts-box').css('display', 'block');
                $('#emergency-alerts-box').addClass('alert alert-danger');

                var html = '';
                
                for(var i = 0; i < feed.items.length && i < 5; i++) {
                
                    var item = feed.items[i];

                    var formatted_description = '';
                    formatted_description = $('<div>').html(item.description).text();

                    html += '<li><h2>'
                    + item.title
                    + '</h2>';
                    
                    html += '<div>'
                    + formatted_description
                    + '</div>';

                    // PHP, RSS, and date.js are really finicky friends...
                    item.updated = item.updated.replace("PDT", "PST");

                    html += '<h5>Updated on '
                    + Date.parse(item.updated).toString('MMMM dd, yyyy')
                    + ' at '
                    + Date.parse(item.updated).toString('h:m tt')
                    + '</h5></li>';
                }

                
                jQuery('#emergency-alerts-box ul').append(html);
            }
        }    
    });
});

</script>
</ul>
</div>
<nav class="navbar navbar-default navbar-static-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <?php echo $html->link($website_preferences['Preference']['website_name'], '/', array('class'=>'navbar-brand')); ?>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
    <?php
        foreach($nav_categories[0] as $category) :
            if ($category['EntryCategory']['category_type'] == 1) {
                // Plain Category
                echo '<li>';
                echo '<a href="' . $site_base_url . 'entries/category/' . $category['EntryCategory']['id'] . $category['EntryCategory']['name'] . '</a>';
                echo '</li>';
            } else if ($category['EntryCategory']['category_type'] == 2) {
                // Special Link
                echo '<li>';
                echo '<a href="' . $category['EntryCategory']['other_link'] . '" target="_blank">' . $category['EntryCategory']['name'] . '</a>';
                echo '</li>';
            } else if ($category['EntryCategory']['category_type'] == 3) {
                // Menu
                echo '<li>';
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $category['EntryCategory']['name'] . ' <b class="caret"></b></a>';
                echo '<ul class="dropdown-menu">';
                foreach ($category['EntryCategoryMenuItem'] as $category_menu_item) {
                    if ($category_menu_item['item_type'] == 1) {
                        // if label
                        echo '<li class="menu-label"><b>' . $category_menu_item['title'] . '</b></li>';
                    } else {
                        // else it's an item
                        // check if we are using a special link
                        if (isset($category_menu_item['other_link']) && $category_menu_item['other_link'] > '') {

                            // use link text if possible
                            if (isset($category_menu_item['other_link_text']) && $category_menu_item['other_link_text'] > '') {
                                echo '<li><a href="' . $category_menu_item['other_link'] . '">' . $category_menu_item['other_link_text'] . '</a></li>';
                            } else {
                                echo '<li><a href="' . $category_menu_item['other_link'] . '">' . $category_menu_item['other_link'] . '</a></li>';
                            }

                        } else {
                            if (isset($nav_categories[1][$category_menu_item['link']]))
                                echo '<li><a href="' . $site_base_url . 'entries/' . $category_menu_item['link'] . '">' . $nav_categories[1][$category_menu_item['link']] . '</a></li>';
                        }
                    }
                }
                echo '</ul>';
                echo '</li>';


            } else if ($category['EntryCategory']['category_type'] == 4) {
                // Widget
                if ($category['EntryCategory']['widget_type'] == 1) {
                echo '<li>';
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $category['EntryCategory']['name'] . ' <b class="caret"></b></a>';
                echo '<ul class="dropdown-menu zebraize">';
                    if (isset($widget_action_links[0])) {
                        $action_link_exploded = explode("&", $widget_action_links[0]);
                        $location = $action_link_exploded[1];
                        echo '<li class="all-staff-link-box">';
                        echo '<a href="">Click here to see all staff!</a>';
                        echo '</li>';
                    }
                    foreach ($widget_action_link_results[1] as $k => $v) {
                        echo '<li>';
                        echo '<p>';
                        echo '<b>' . $v->firstname . ' ' . $v->lastname . '</b><br />';
                        echo $v->positionname . '<br />';
                        if ($v->offphone)
                            echo 'phone: ' . $v->offphone . '<br />';
                        if ($v->offext)
                            echo 'ext: ' . substr($v->offext, 0, 4) . '<br />';
                        if ($v->email)
                            echo '<a href="mailto:' . $v->email . '">email</a> / ';
                        else
                            echo 'email / ';
                        if ($v->homepage)
                            echo '<a href="' . $v->homepage . '">homepage</a> / ';
                        else
                            echo 'homepage / ';
                        if ($v->blog)
                            echo '<a href="' . $v->blog . '">blog</a>';
                        else
                            echo 'blog';
                        echo '</p>';
                        echo '</li>';
                    }
                echo '</ul>';
                echo '</li>';
                }
            }
        endforeach;
    ?>
    </ul>
    <form method="get" action="http://www.google.com/search" accept-charset="utf-8" class="navbar-form navbar-right search-box" role="search">
      <div class="form-group">
        <?php
            $domain = $site_base_url;
            $domain = str_replace('http://', '', $domain);
        ?>
        <input name="q" type="text" class="form-control input-sm" placeholder="Search">
        <input type="hidden" name="domains" value="<?php echo $domain ?>" /><input type="hidden" name="sitesearch" value="<?php echo $domain ?>" />
      </div>
      <button type="submit" class="btn btn-default btn-sm">Search</button>
    </form>
  </div><!-- /.navbar-collapse -->
</nav>

<div class="page-header">
<div class="btn-group btn-group-sm pull-right mini-menus">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    Language <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="#" id="make_me_spanish_link">Espa&#241;ol</a></li>
  </ul>
</div>

<?php

    foreach ($mini_menus as $mini_menu) {

        echo '<div class="btn-group btn-group-sm mini-menus">';
        echo '  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">';
        echo '    ' . strip_tags($mini_menu['MiniMenu']['name']) . ' <span class="caret"></span>';
        echo '  </button>';
        echo '  <ul class="dropdown-menu" role="menu">';
        foreach ($mini_menu['MiniMenuItem'] as $k => $v) {
            echo '<li><a href="' . $v['other_link'] . '">' . $v['other_link_text'] . '</a></li>';
        }
        echo '  </ul>';
        echo '</div>';
    }

    $domain = $site_base_url;
    $domain = str_replace('http://', '', $domain);
?>
</div>
<?php if ($website_preferences['Preference']['banner_message']) : ?>
<div class="banner-message"><div class="alert alert-info"><?php echo $website_preferences['Preference']['banner_message']; ?></div></div>
<?php endif; ?>
<div class="container">
<!-- Here's where I want my views to be displayed -->
<?php echo $content_for_layout ?>

<div id="footer">
<?php echo $website_preferences['Preference']['footer']; ?>

<div id="footer-nav">
  <?php echo $html->link('Login', '/home/indoors', array('class'=>'btn btn-primary btn-xs')); ?>
  <a href="<?php echo $website_preferences['Preference']['emergency_alerts_link'] ?>" class="btn btn-warning btn-xs" >Emergency Alerts</a>
  <a href="<?php echo $syndicate_announcements_url ?>" class="btn btn-warning btn-xs">Latest Announcements</a>
  <a href="<?php echo $syndicate_news_url ?>" class="btn btn-warning btn-xs">Latest News</a>
  <a href="" class="btn btn-success btn-xs">Contact Us</a>
</div>

</div> <!-- end of footer -->
</div> <!-- end of container -->

<!-- Javascripts -->
<!--<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.menu.min.js"></script> -->
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.curvycorners.js"></script>
<!--<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.hoverIntent.minified.js"></script> -->
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.jfeed.pack.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/date.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jtwitters.js"></script>
<script type="text/javascript" src="<?php echo $website_theme_url . '/' . $website_preferences['Preference']['website_theme']; ?>/default.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>bootstrap/js/bootstrap.min.js"></script>
<?php echo $scripts_for_layout ?>

<script type="text/javascript">

// For Twitter
jQuery(function() {
    <?php
        if ($website_preferences['Preference']['show_twitter_feed'] == 1) :
            $count = 1;
            $username = 'google';
            $cachetime = '10';

            if ($website_preferences['Preference']['twitter_feed_limit'])
                $count = (int)$website_preferences['Preference']['twitter_feed_limit'];
            if ($website_preferences['Preference']['twitter_feed_username'])
                $username = $website_preferences['Preference']['twitter_feed_username'];
            if ($website_preferences['Preference']['cache_twitter_feed'])
                $cache = $website_preferences['Preference']['cache_twitter_feed'];
            else
                $cache = 0;
            if ($website_preferences['Preference']['twitter_feed_cache_time'])
                $cachetime = $website_preferences['Preference']['twitter_feed_cache_time'];
    ?>

    $('#twitter_box').jtwitters({
        count: <?php echo $count ?>,
        username: "<?php echo $username ?>",
        cache: <?php echo $cache ?>,
        cachetime: <?php echo $cachetime ?>,
        getcachefile: "<?php echo $site_base_url; ?>tweets/get_feed/1",
        postcachefile: "<?php echo $site_base_url; ?>tweets/cache_feed/1"
    }).fadeIn('slow');

    <?php
        endif;
    ?>

    $('#calendar_events_box .welcome_side_box_datestamp').each(function(i) {
        var calendar_date_array = $(this).text().split(" ");
        $(this).parent().parent().find('.icon_calendar').text(parseInt(calendar_date_array[2]));
    });
});

</script>

</body>
</html>
