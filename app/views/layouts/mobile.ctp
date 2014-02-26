<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_for_layout?></title>
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/smoothness/jquery-ui-1.8.2.custom.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/mobile.css" />

<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/mobile.js"></script>

<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<base href="<?php echo Router::url('/'); ?>" />
<?php echo $scripts_for_layout ?>
</head>
<body>
<div id="header">
<h2><?php echo $html->link($website_preferences['Preference']['website_name'], '/mobile/m_welcome'); ?></h2>
</div>
<div id="nav">
<ul>
<li><a href="<?php echo $site_base_url . 'mobile/m_welcome'; ?>">Home</a></li>
<li><a href="<?php echo $site_base_url . 'mobile/m_staff_list'; ?>">Staff List</a></li>
<li><a href="<?php echo $site_base_url . 'mobile/m_calendar'; ?>">Calendar</a></li>
</ul>
</div>
<div id="content">

<!-- Here's where I want my views to be displayed -->
<?php echo $content_for_layout ?>

<br style="clear:both;" />
<div id="footer">
<?php echo $website_preferences['Preference']['footer']; ?>
</div>
<div id="footer2">
<?php echo $website_preferences['Preference']['extra_footer']; ?>
</div>

<div id="footer_nav">
<ul>
    <li><span class="large_icon">&#82;&#115;&#115;</span><a href="<?php echo $website_preferences['Preference']['emergency_alerts_link'] ?>">Emergency Alerts</a></li>
    <li><span class="large_icon">&#82;&#115;&#115;</span><a href="<?php echo $syndicate_announcements_url ?>">Latest Announcements</a></li>
    <li><span class="large_icon">&#82;&#115;&#115;</span><a href="<?php echo $syndicate_news_url ?>">Latest News</a></li>
    </ul>
<br /><br />
<a href="<?php echo $site_base_url ?>?full=true">Full Site</a> | <a href="<?php echo $site_base_url . 'mobile/m_welcome' ?>">Mobile Site</a>
    </div>
    </div>


</body>
</html>
