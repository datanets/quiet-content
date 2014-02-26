<?php
    echo $form->create('User', array('action' => 'remove'));
?>

<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Delete Checked User(s)', array('type' => 'submit', 'id' => 'index_delete'));
?>
</span>

<h1>User</h1>
<?php echo $html->link('+ New User', '/users/create'); ?>
</div>

<div id="single_column">
<table id="table_list_users" cellpadding="0" cellspacing="0" border="0" class="display">
    <thead>
    <tr>
        <th></th>
        <th>Username</th>
        <th>User Type</th>
        <th>Edit</th>
    </tr>
    </thead>
    <tbody>

    <?php for ($i = 0; $i < count($users); $i++) : ?>
    <tr>
        <td><?php echo $form->checkbox('User' . $users[$i]['User']['id'] . 'delete'); ?></td>
        <td><?php echo ($users[$i]['User']['username']) ? $html->link($users[$i]['User']['username'], '/users/edit/' . $users[$i]['User']['id']) : '-'; ?></td>
        <td><?php echo ($users[$i]['User']['usertype']) ? $usertypes[$users[$i]['User']['usertype']] : '-'; ?></td>
        <td><?php echo $html->link('Edit', '/users/edit/' . $users[$i]['User']['id']); ?></td>
    </tr>
    <?php endfor; ?>
    </tbody>

</table>
</div>

<?php
    echo $form->end();
?>
