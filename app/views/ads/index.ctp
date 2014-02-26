<?php
    echo $form->create('Ad', array('action' => 'remove'));
?>

<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Delete Checked Ads', array('type' => 'submit', 'id' => 'index_delete'));
?>
</span>

<h1>Ads</h1>
<?php echo $html->link('+ New Ad', '/ads/create'); ?>
</div>

<div id="single_column">
<table id="table_list_ads" cellpadding="0" cellspacing="0" border="0" class="display">
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
    <?php for ($i = 0; $i < count($ads); $i++) : ?>
    <?php $datetime = strtotime($ads[$i]['Ad']['modified']);  ?>
    <tr>
        <td><?php echo $form->checkbox('Ad' . $ads[$i]['Ad']['id'] . 'delete'); ?></td>
        <td><?php echo ($ads[$i]['Ad']['subject']) ? $html->link($ads[$i]['Ad']['subject'], '/ads/edit/' . $ads[$i]['Ad']['id']) : '-'; ?></td>
        <td><?php echo ($ads[$i]['Ad']['modified']) ? date("M. d, Y", $datetime) : '-'; ?></td>
        <td><?php echo ($ads[$i]['Ad']['modified']) ? date("H:i", $datetime) : '-'; ?></td>
        <td><?php echo $html->link('Edit', '/ads/edit/' . $ads[$i]['Ad']['id']); ?></td>
    </tr>
    <?php endfor; ?>
    </tbody>

</table>
</div>

<?php
    echo $form->end();
?>
