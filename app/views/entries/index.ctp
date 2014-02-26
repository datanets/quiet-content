<?php
    echo $form->create('Entry', array('action' => 'remove'));
?>

<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Delete Checked Entries', array('type' => 'submit', 'id' => 'index_delete'));
?>
</span>

<h1>Entries</h1>
<?php echo $html->link('+ New Entry', '/entries/create'); ?>
</div>

<div id="single_column">
<table id="table_list_entries" cellpadding="0" cellspacing="0" border="0" class="display">
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
    <?php for ($i = 0; $i < count($entries); $i++) : ?>
    <?php $datetime = strtotime($entries[$i]['Entry']['modified']);  ?>
    <tr>
        <td><?php echo $form->checkbox('Entry' . $entries[$i]['Entry']['id'] . 'delete'); ?></td>
        <td><?php echo ($entries[$i]['Entry']['subject']) ? $html->link($entries[$i]['Entry']['subject'], '/entries/edit/' . $entries[$i]['Entry']['id']) : '-'; ?></td>
        <td><?php echo ($entries[$i]['Entry']['modified']) ? date("M. d, Y", $datetime) : '-'; ?></td>
        <td><?php echo ($entries[$i]['Entry']['modified']) ? date("H:i", $datetime) : '-'; ?></td>
        <td><?php echo $html->link('Edit', '/entries/edit/' . $entries[$i]['Entry']['id']); ?></td>
    </tr>
    <?php endfor; ?>
    </tbody>

</table>
</div>

<?php
    echo $form->end();
?>
