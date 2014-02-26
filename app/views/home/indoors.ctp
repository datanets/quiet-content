<div id="dashboard_main_box">
<div id="content_heading">
<h1>Dashboard</h1>
</div>

<div id="single_column">
<div id="dashboard">
<ul>
<li>
<div class="dashboard_item">
<h3>Recent Announcements</h3>
<ul>
<?php
    foreach($recent_announcements as $k => $v) :
        $date_modified = strtotime($v['Announcement']['modified']);
?>
    <li><a href="<?php echo $site_base_url; ?>announcements/edit/<?php echo $v['Announcement']['id']; ?>"><?php echo ($v['Announcement']['subject'] > '') ? $v['Announcement']['subject'] : '(no title)'; ?></a><h5>Date Modified: <?php echo date("F d, Y H:i:s", $date_modified) ?></h5></li>
<?php
    endforeach;
?>
</ul>
</div>
</li>
<li>
<div class="dashboard_item">
<h3>Recent Entries</h3>
<ul>
<?php
    foreach($recent_entries as $k => $v) :
        $date_modified = strtotime($v['Entry']['modified']);
?>
    <li><a href="<?php echo $site_base_url; ?>entries/edit/<?php echo $v['Entry']['id']; ?>"><?php echo ($v['Entry']['subject'] > '') ? $v['Entry']['subject'] : '(no title)'; ?></a><h5>Date Modified: <?php echo date("F d, Y H:i:s", $date_modified) ?></h5></li>
<?php
    endforeach;
?>
</ul>
</div>
</li>

<li>
<div class="dashboard_item">
<h3>Recent News</h3>
<ul>
<?php
    foreach($recent_news as $k => $v) :
        $date_modified = strtotime($v['News']['modified']);
?>
    <li><a href="<?php echo $site_base_url; ?>news/edit/<?php echo $v['News']['id']; ?>"><?php echo ($v['News']['subject'] > '') ? $v['News']['subject'] : '(no title)'; ?></a><h5>Date Modified: <?php echo date("F d, Y H:i:s", $date_modified) ?></h5></li>
<?php
    endforeach;
?>
</ul>
</div>
</li>



</ul>

</div>
</div>
