<div id="content_heading">

<h1><?php echo $html->link('Preferences', '/preferences'); ?></h1>
</div>
<div id="single_column">
<div id="preferences_box">
<ul>
<?php if ($user['usertype'] == 1) : ?>
<li><?php echo $html->link('Clear Cache', '/preferences/clear_cache'); ?></li>
<li><?php echo $html->link('Mini Menus', '/mini_menus'); ?></li>
<li><?php echo $html->link('Website', '/preferences/website'); ?></li>
<li><?php echo $html->link('Widgets', '/preferences/widgets'); ?></li>
<li><?php echo $html->link('Your Account', '/users/your_account'); ?></li>
<?php else : ?>
<li><?php echo $html->link('Your Account', '/users/your_account'); ?></li>
<?php endif; ?>
</ul>
</div>
</div>
<br />

<br style="clear:both;" />

