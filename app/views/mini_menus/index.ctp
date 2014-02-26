<?php
    echo $form->create('MiniMenu', array('action' => 'remove'));
?>

<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Delete Checked Mini Menus', array('type' => 'submit', 'id' => 'index_delete'));
?>
</span>

<h1>Mini Menus</h1>
<?php echo $html->link('+ New Mini Menu', '/mini_menus/create'); ?>
</div>

<div id="single_column">
<table id="table_list_mini_menus" cellpadding="0" cellspacing="0" border="0" class="display">
    <thead>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Date Modified</th>
        <th>Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 0; $i < count($mini_menus); $i++) : ?>
    <?php $datetime = strtotime($mini_menus[$i]['MiniMenu']['modified']);  ?>
    <tr>
        <td><?php echo $form->checkbox('MiniMenu' . $mini_menus[$i]['MiniMenu']['id'] . 'delete'); ?></td>
        <td><?php echo ($mini_menus[$i]['MiniMenu']['name']) ? $html->link($mini_menus[$i]['MiniMenu']['name'], '/mini_menus/edit/' . $mini_menus[$i]['MiniMenu']['id']) : '-'; ?></td>
        <td><?php echo ($mini_menus[$i]['MiniMenu']['modified']) ? date("M. d, Y @ H:i", $datetime) : '-'; ?></td>
        <td><?php echo $html->link('Edit', '/mini_menus/edit/' . $mini_menus[$i]['MiniMenu']['id']); ?></td>
    </tr>
    <?php endfor; ?>
    </tbody>

</table>
</div>

<?php
    echo $form->end();
?>
