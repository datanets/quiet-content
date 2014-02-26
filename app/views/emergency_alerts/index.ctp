<?php
    echo $form->create('EmergencyAlert', array('action' => 'remove'));
?>

<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Delete Checked Emergency Alerts', array('type' => 'submit', 'id' => 'index_delete'));
?>
</span>

<h1>Emergency Alerts</h1>
<?php echo $html->link('+ New Emergency Alert', '/emergency_alerts/create'); ?>
</div>

<div id="single_column">
<table id="table_list_emergency_alerts" cellpadding="0" cellspacing="0" border="0" class="display">
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
    <?php for ($i = 0; $i < count($emergency_alerts); $i++) : ?>
    <?php $datetime = strtotime($emergency_alerts[$i]['EmergencyAlert']['modified']);  ?>
    <tr>
        <td><?php echo $form->checkbox('EmergencyAlert' . $emergency_alerts[$i]['EmergencyAlert']['id'] . 'delete'); ?></td>
        <td><?php echo ($emergency_alerts[$i]['EmergencyAlert']['subject']) ? $html->link($emergency_alerts[$i]['EmergencyAlert']['subject'], '/emergency_alerts/edit/' . $emergency_alerts[$i]['EmergencyAlert']['id']) : '-'; ?></td>
        <td><?php echo ($emergency_alerts[$i]['EmergencyAlert']['modified']) ? date("M. d, Y", $datetime) : '-'; ?></td>
        <td><?php echo ($emergency_alerts[$i]['EmergencyAlert']['modified']) ? date("H:i", $datetime) : '-'; ?></td>
        <td><?php echo $html->link('Edit', '/emergency_alerts/edit/' . $emergency_alerts[$i]['EmergencyAlert']['id']); ?></td>
    </tr>
    <?php endfor; ?>
    </tbody>

</table>
</div>

<?php
    echo $form->end();
?>
