<div id="content_heading">
<h1><?php echo $html->link('Preferences', '/preferences'); ?> &rsaquo; Widgets</h1>
</div>
<div id="left_column">
<ul>
<?php

foreach ($website_preferences['Widget'] as $k => $v) {
    echo '<li><a href="' . $site_base_url . 'widgets/edit/' . $v['id'] . '">' . $v['title'] . '</a></li>';
}

?>
</ul>
</div>
</div>
<br style="clear:both;" />

