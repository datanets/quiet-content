<?php
    echo $form->create('Announcement', array('action' => 'remove'));
?>

<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Delete Checked Announcements', array('type' => 'submit', 'id' => 'index_delete'));
?>
</span>

<h1>Announcements</h1>
<?php echo $html->link('+ New Announcement', '/announcements/create'); ?>
</div>

<div id="single_column">
<table id="table_list_announcements" cellpadding="0" cellspacing="0" border="0" class="display">
    <thead>
    <tr>
        <th></th>
        <th>Subject</th>
        <th>Date Modified</th>
        <th>Time Modified</th>
        <th>Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 0; $i < count($announcements); $i++) : ?>
    <?php $datetime = strtotime($announcements[$i]['Announcement']['modified']);  ?>
    <tr>
        <td><?php echo $form->checkbox('Announcement' . $announcements[$i]['Announcement']['id'] . 'delete'); ?></td>
        <td><?php echo ($announcements[$i]['Announcement']['subject']) ? $html->link($announcements[$i]['Announcement']['subject'], '/announcements/edit/' . $announcements[$i]['Announcement']['id']) : '-'; ?></td>
        <td><?php echo ($announcements[$i]['Announcement']['modified']) ? date("M. d, Y", $datetime) : '-'; ?></td>
        <td><?php echo ($announcements[$i]['Announcement']['modified']) ? date("H:i", $datetime) : '-'; ?></td>
        <td><?php echo $html->link('Edit', '/announcements/edit/' . $announcements[$i]['Announcement']['id']); ?></td>
    </tr>
    <?php endfor; ?>
    </tbody>

</table>
</div>

<?php
    echo $form->end();
?>
