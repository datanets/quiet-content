<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_for_layout?></title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/smoothness/jquery-ui-1.8.2.custom.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/old_main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/admin_main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/droppy.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/jquery_menu.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/demo_page.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/demo_table_jui.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/timePicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $site_base_url; ?>js/markitup/skins/custom_simple/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $site_base_url; ?>js/markitup/sets/html/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/prettyPhoto.css" />
<!--<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>js/jsTree/_docs/!style.css" />-->

<!--<<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-1.3.2.min.js"></script>-->
<!--<<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-ui-1.7.2.custom.min.js"></script>-->
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/admin_main.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.menu.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.jeditable.mini.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-fieldselection.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.corner.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.timePicker.js"></script>
<!--<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.scrollTo-1.4.2-min.js"></script>-->
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/markitup/sets/html/set.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.throbber.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery.prettyPhoto.js"></script>
<!--<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jsTree/jquery.jstree.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jsTree/_lib/jquery.cookie.js"></script>-->

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<base href="<?php echo Router::url('/'); ?>" />
<?php echo $scripts_for_layout ?>
</head>
<body>
<div id="admin_header">
    <ul id="admin_nav">
        <li style="float:right;padding:0px;color:white;font-family: arial, sans-serif; font-size: 15px; font-weight:bold; padding-top:0px; padding-right:10px;"></li>
        <li style="float:right;padding:0px;color:white;font-family: arial, sans-serif; font-size: 15px; padding-top:0px; padding-right:10px
;">
        <li><?php echo $html->link('Dashboard', '/home/indoors'); ?></li>
        <li class="menu_category">Manage
            <ul>
                <li><?php echo $html->link('Ads', '/ads'); ?>
                    <ul>
                        <li><?php echo $html->link('New Ad', '/ads/create'); ?></li>
                        <li><?php echo $html->link('View All', '/ads'); ?></li>
                    </ul>
                </li>
                <li><?php echo $html->link('Announcements', '/announcements'); ?>
                    <ul>
                        <li><?php echo $html->link('New Announcement', '/announcements/create'); ?></li>
                        <li><?php echo $html->link('View All', '/announcements'); ?></li>
                        <li><?php echo $html->link('Categories', '/announcement_categories'); ?></li>
                    </ul>
                </li>
                <?php
                    if (isset($emergency_alerts_sender) && $emergency_alerts_sender) {
                ?>
                        <li><?php echo $html->link('Emergency Alerts', '/emergency_alerts'); ?>
                            <ul>
                                <li><?php echo $html->link('New Emergency Alert', '/emergency_alerts/create'); ?></li>
                                <li><?php echo $html->link('View All', '/emergency_alerts'); ?></li>
                            </ul>
                        </li>
                <?php
                    }
                ?>
                <li><?php echo $html->link('Entries', '/entries'); ?>
                    <ul>
                        <li><?php echo $html->link('New Entry', '/entries/create'); ?></li>
                        <li><?php echo $html->link('View All', '/entries'); ?></li>
                        <li><?php echo $html->link('Categories', '/entry_categories'); ?></li>
                    </ul>
                </li>
                <li><?php echo $html->link('Files', '/file_managers'); ?></li>
                <li><?php echo $html->link('News', '/news'); ?>
                    <ul>
                        <li><?php echo $html->link('New News', '/news/create'); ?></li>
                        <li><?php echo $html->link('View All', '/news'); ?></li>
                        <li><?php echo $html->link('Categories', '/news_categories'); ?></li>
                    </ul>
                </li>
                <li><?php echo $html->link('Users', '/users'); ?>
                    <ul>
                        <li><?php echo $html->link('New User', '/users/create'); ?></li>
                        <li><?php echo $html->link('View All', '/users'); ?></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="menu_category" style="padding-left:10px;">View
            <ul>
                <li><?php echo $html->link('Homepage', '/'); ?></li>
            </ul>
        </li>
        <li class="menu_category" style="padding-left:10px;">Preferences
            <ul>
                <li><?php echo $html->link('All', '/preferences'); ?></li>
                <li><?php echo $html->link('Clear Cache', '/preferences/clear_cache'); ?></li>
                <li><?php echo $html->link('Mini Menus', '/mini_menus'); ?></li>
                <li><?php echo $html->link('Website', '/preferences/website'); ?></li>
                <li><?php echo $html->link('Widgets', '/preferences/widgets'); ?></li>
                <li><?php echo $html->link('Your Account', '/users/your_account'); ?></li>
                <li><?php echo $html->link('Change Password', '/users/change_password'); ?></li>
            </ul>
        </li>
        <li class="menu_category" style="padding-left:10px;"><?php echo $html->link('Help', '/docs/index.html'); ?></li>
        <li><?php echo $html->link('Logout', '/users/logout'); ?></li>
    </ul>
</div>


<div id="admin_content">

<?php
    if($session->check('Message.flash')) :
?>
<div id="dialog_box">
<?php echo $session->flash(); ?>
</div>
<?php
    else :
?>
<div id="dialog_box_off">
</div>
<?php
    endif;
?>

<!-- Here's where I want my views to be displayed -->
<?php echo $content_for_layout ?>

<br style="clear:both;" />
<div id="admin_footer">
</div>
</div>
</body>
</html>
