<?php

    function list_children($item, $site_base_url = null) {

        if (isset($item['children']) && $item['children']) {

            ?>
            <ul>
            <?php

            for ($i=0; $i<count($item['children']); $i++) :

            ?>
            <li id="side_nav_<?php echo $item['children'][$i]['EntryCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $item['children'][$i]['EntryCategory']['name']) ?>" class="category_link"><?php echo $item['children'][$i]['EntryCategory']['name'] ?></a>
            <?php

                if (count($item['children'][$i]['Entry'] > 0)) {

            ?>
                    <ul>
                    <?php

                    foreach($item['children'][$i]['Entry'] as $list_entry) :

                        $subject = $list_entry['subject'];
                        if ($subject == '')
                            $subject = 'Untitled Entry';

                        echo '<li id="side_nav_' . $list_entry['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'entries/' . $list_entry['id'] . '">' . $subject . '</a></li>';

                    endforeach;

                    
                    ?>
                    </ul>
            <?php

                }

                if (isset($item['children'][$i]['children']) && count($item['children'][$i]['children']) > 0) {
                    list_children($item['children'][$i], $site_base_url);
                }
            ?>
            </li>
            <?php

            endfor;

            ?>
            </ul>
            <?php

        }

    }

?>

<div id="single_page">

<div id="side_nav">

<?php for ($i=0; $i<count($categories); $i++) : ?>
    <ul>
    <li id="side_nav_<?php echo $categories[$i]['EntryCategory']['id'] ?>"><a href="#<?php echo preg_replace("/[^\w]+/", "_", $categories[$i]['EntryCategory']['name']) ?>" class="category_link"><?php echo $categories[$i]['EntryCategory']['name'] ?></a>
    <?php

         if (count($categories[$i]['Entry'] > 0)) {

    ?>
            <ul>
            <?php

            foreach($categories[$i]['Entry'] as $list_entry) :

                $subject = $list_entry['subject'];
                if ($subject == '')
                    $subject = 'Untitled Entry';

                echo '<li id="side_nav_' . $list_entry['id'] . '" class="side_nav_item"><a href="' . $site_base_url . 'entries/' . $list_entry['id'] . '">' . $subject . '</a></li>';

            endforeach;

            
            ?>
            </ul>
    <?php

        }

    ?>
    <?php list_children($categories[$i], $site_base_url); ?>
    </li>
    </ul>
<?php endfor; ?>

</div>
<div id="page_entry">

<cake:nocache>
<?php if (isset($user) && $user && $user['usertype'] <= 2) : ?>
<div class="actions" style="display:block;">
	<ul>
        <li><b>Actions:</b></li>
		<li><?php echo $this->Html->link(__('Admin Home', true), array('controller' => 'home', 'action' => 'indoors')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('action' => 'create')); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Entry', true), array('action' => 'edit', $entry['Entry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Entry', true), array('action' => 'remove', $entry['Entry']['id']), null, sprintf(__('Are you sure you want to delete this entry?', true), $entry['Entry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'logout')); ?> </li>
	</ul>
</div>
<?php endif; ?>
</cake:nocache>


<h2><?php echo $entry['Entry']['subject']; ?></h2>
<div id="story_date_box">
<ul>
<?php

$date_created = strtotime($entry['Entry']['created']);
$date_modified = strtotime($entry['Entry']['modified']);

echo '<li>Published: ' . date("F d, Y", $date_created) . ' by ';
if ($entry['Entry']['author_created'] > '')
    echo '<a href="mailto:' . $users[$entry['Entry']['author_created']]['email'] . '">' . $users[$entry['Entry']['author_created']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';
echo '<li>Updated: ' . date("F d, Y", $date_modified) . ' by ';
if ($entry['Entry']['author_modified'] > '')
    echo '<a href="mailto:' . $users[$entry['Entry']['author_modified']]['email'] . '">' . $users[$entry['Entry']['author_modified']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';

?>
</ul>
</div>
<?php if (isset($entry['Entry']['splash_image']) && $entry['Entry']['splash_image']) : ?>
<div id="single_page_splash_image">
<a href="<?php echo $splash_images_base_url . $entry['Entry']['splash_image'] ?>" rel="prettyPhoto[images]"><img src="<?php echo $splash_images_base_url . $entry['Entry']['splash_image']; ?>" /></a>
</div>
<?php endif; ?>
<?php echo $entry['Entry']['entry']; ?>

<br style="clear:both;" />
<?php
    if (isset($entry['EntryImage']) && count($entry['EntryImage']) > 0) :
?>
<div id="view_image_box">
<a name="images"></a>
<h3>Images</h3>
<?php

    foreach($entry['EntryImage'] as $image) {

        echo '<a href="' . $entry_images_base_url . $image['name'] . '" rel="prettyPhoto[images]"><img src="' . $entry_images_base_url . $image['name'] . '" /></a>';

    }

?>
</div>
<?php
    endif;

    if (isset($entry['EntryAttachment']) && count($entry['EntryAttachment']) > 0) :
?>
<div id="view_attachment_box">
<a name="attachments"></a>
<h3>Attachments</h3>
<?php

    foreach($entry['EntryAttachment'] as $attachment) {

        echo '<ul>';
        echo '<li>';
        echo '<span style="float:right;font-size:x-small;">&#9906;&nbsp;<a href="' . $entry_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[attachments_a]">Preview</a>&nbsp;&nbsp;&nbsp;&#11015;&nbsp;<a href="' . $site_base_url . 'entries/download/?file=' . $entry_attachments_base_url . $attachment['name'] . '">Download</a></span>';
        echo '<a href="' . $entry_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[attachments_b]" /><img src="' . $site_base_url . 'img/file_16.gif" /></a><a href="' . $entry_attachments_base_url . $attachment['name'] . '" rel="prettyPhoto[attachments_c]" />' . $attachment['name'] . '</a>';
        echo '</li>';
        echo '</ul>';

    }

?>
</div>
<?php
    endif;
?>

</div>


</div>

<?php
echo '<input type="hidden" id="current_id" value="' . $current_id . '" />';
echo '<input type="hidden" id="parents_path" value="' . $parents_path . '" />';
?>
