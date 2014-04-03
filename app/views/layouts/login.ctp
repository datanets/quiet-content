<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_for_layout?></title>
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/smoothness/jquery-ui-1.8.2.custom.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/old_main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/admin_main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_base_url; ?>css/droppy.css" />

<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $site_base_url; ?>js/jquery-ui-1.8.2.custom.min.js"></script>


<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<base href="<?php echo Router::url('/'); ?>" />
<?php echo $scripts_for_layout ?>
</head>
<body>
<div id="admin_header">
    <ul id="admin_nav">
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
