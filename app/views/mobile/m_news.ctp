<div id="story_box">
<?php

    if (isset($this->data['News'])) {


        if (isset($this->data['News']['splash_image']) && $this->data['News']['splash_image'] > '') {
            echo '<img src="' . $splash_images_base_url . $this->data['News']['splash_image'] . '" id="splash_image">';
        }
        echo '<div class="box">';
        echo '<h3>' . $this->data['News']['subject'] . '</h3>';

?>
<div id="story_date_box">
<ul>
<?php

$date_created = strtotime($this->data['News']['created']);
$date_modified = strtotime($this->data['News']['modified']);

/*
echo '<li>Published: ' . date("F d, Y", $date_created) . ' by ';
if ($this->data['News']['author_created'] > '')
    echo '<a href="mailto:' . $users[$this->data['News']['author_created']]['email'] . '">' . $users[$this->data['News']['author_created']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';
*/
echo '<li>Updated: ' . date("F d, Y", $date_modified) . ' by ';

if ($this->data['News']['author_modified'] > '')
    echo '<a href="mailto:' . $users[$this->data['News']['author_modified']]['email'] . '">' . $users[$this->data['News']['author_modified']]['first_name'] . '</a>';
else
    echo 'Anonymous';
echo '</li>';

?>
</ul>
</div>
<?php

        echo $this->data['News']['entry'];
        echo '</div>';

    }


?>
</div>

