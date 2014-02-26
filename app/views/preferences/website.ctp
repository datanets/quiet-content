<?php
    echo $form->create('Preference', array('action' => 'website'));
?>
<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Save Changes', array('type' => 'submit'));
?>
</span>
<h1><?php echo $html->link('Preferences', '/preferences'); ?> &rsaquo; Website</h1>
</div>
<div id="left_column">

<label>Website Name :</label>
<?php
echo $form->input('Preference.website_name', array('style' => 'width:250px;', 'label' => false, 'value' => $preferences['Preference']['website_name']));
?>
<br />
<label>Footer:</label>
<?php
echo $form->input('Preference.footer', array('style' => 'width:600px;', 'rows' => '10', 'label' => false, 'class' => 'entry_body', 'value' => $preferences['Preference']['footer']));
?>
<br />
<label>Extra Footer:</label>
<?php
echo $form->input('Preference.extra_footer', array('style' => 'width:600px;', 'rows' => '10', 'label' => false, 'class' => 'entry_body', 'value' => $preferences['Preference']['extra_footer']));
?>
<br />

<label>Website Theme:</label>
<div class="input text">
<?php
echo $form->select('Preference.website_theme', $website_themes, $preferences['Preference']['website_theme'], array('empty' => false, 'escape' => false))
?>
</div>
<br />
<label>Website Calendar Link:</label>
<?php
echo $form->input('Preference.website_calendar_link', array('style' => 'width:600px;', 'label' => false, 'value' => $preferences['Preference']['website_calendar_link']));
?>
<br />
<label>Website Calendar Source:</label>
<?php
echo $form->input('Preference.website_calendar', array('style' => 'width:600px;', 'label' => false, 'value' => $preferences['Preference']['website_calendar']));
?>
<br />
<label>Emergency Alerts Link:</label>
<?php
echo $form->input('Preference.emergency_alerts_link', array('style' => 'width:600px;', 'label' => false, 'value' => $preferences['Preference']['emergency_alerts_link']));
?>
<br />
<label>Webmaster Email:</label>
<?php
echo $form->input('Preference.webmaster_email', array('style' => 'width:250px;', 'label' => false, 'value' => $preferences['Preference']['webmaster_email']));
?>
<br />
<label>Number of Announcements Featured on Home Page:</label>
<?php
$total_shown = array_combine(range(1,10), range(1,10));
echo $form->select('Preference.featured_announcements_limit', $total_shown, $preferences['Preference']['featured_announcements_limit'], array('empty' => false, 'escape' => false))
?>
<br />
<br />
<label>Twitter Feed Username:</label>
<?php
echo $form->input('Preference.twitter_feed_username', array('style' => 'width:250px;', 'label' => false, 'value' => $preferences['Preference']['twitter_feed_username']));
?>
<br />
<label>Number of Tweets Shown on Home Page:</label>
<?php
$total_shown = array_combine(range(1,10), range(1,10));
echo $form->select('Preference.twitter_feed_limit', $total_shown, $preferences['Preference']['twitter_feed_limit'], array('empty' => false, 'escape' => false))
?>
<br />
<br />
<label>Show Twitter Feed:</label>
<?php
if ($preferences['Preference']['show_twitter_feed']) {
    echo $form->checkbox('Preference.show_twitter_feed', array('checked' => 'checked'));
} else {
    echo $form->checkbox('Preference.show_twitter_feed');
}
?>
<br />
<br />
<label>Cache Twitter Feed:</label>
<?php
if ($preferences['Preference']['cache_twitter_feed']) {
    echo $form->checkbox('Preference.cache_twitter_feed', array('checked' => 'checked'));
} else {
    echo $form->checkbox('Preference.cache_twitter_feed');
}
?>

<br />
<br />
<label>Twitter Feed Cache after X minutes (within an hour):</label>
<?php
echo $form->input('Preference.twitter_feed_cache_time', array('style' => 'width:250px;', 'label' => false, 'value' => $preferences['Preference']['twitter_feed_cache_time']));
?>
<br />
<br />
<label>Banner Message:</label>
<?php
echo $form->input('Preference.banner_message', array('style' => 'width:600px;', 'rows' => '10', 'label' => false, 'class' => 'entry_body', 'value' => $preferences['Preference']['banner_message']));
?>


<div style="display:none;">
<?php
echo $form->input('Preference.id', array('style' => 'width:250px;', 'label' => false, 'value' => $preferences['Preference']['id']));
?>
</div>
</div>
<?php
    echo $form->end();
?>
<br style="clear:both;" />

