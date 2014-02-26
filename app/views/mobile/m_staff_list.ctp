<?php

if (isset($widget_action_links[0])) {
    $action_link_exploded = explode("&", $widget_action_links[0]);
    $location = $action_link_exploded[1];
}

echo '<div id="list_box">';
echo '<h3>Staff List</h3>';
echo '<ul>';
foreach ($widget_action_link_results[1] as $k => $v) {
    echo '<li><a name="' . $v->email . '"></a><a href="' . $site_base_url . 'mobile/m_list#' . $v->email . '" class="staff_name">' . $v->firstname . ' ' . $v->lastname . '</a>';
    echo '<div class="list_details_box">';
    echo '<table>';
    echo '<tr><td>Email: </td><td><a href="mailto:' . $v->email . '">' . $v->email . '</a></td></tr>';
    echo '<tr><td>Phone: </td><td>' . $v->offphone . '</td></tr>';
    echo '<tr><td>Ext: </td><td>' . $v->offext . '</td></tr>';
    if ($v->homepage > '')
        echo '<tr><td>&nbsp;</td><td><a href="' . $v->homepage . '">Homepage</a></td></tr>';
    if ($v->blog > '')
        echo '<tr><td>&nbsp;</td><td><a href="' . $v->blog . '">Blog</a></td></tr>';
    echo '</table>';
    echo '</div>';
    echo '</li>';
}
echo '</ul>';
echo '</div>';

?>
