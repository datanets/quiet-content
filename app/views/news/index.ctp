<?php
    echo $form->create('News', array('action' => 'remove'));
?>

<div id="content_heading">

<span style="float:right;margin-right:5px;">
<?php
    echo $form->button('Delete Checked News', array('type' => 'submit', 'id' => 'index_delete'));
?>
</span>

<h1>News</h1>
<?php echo $html->link('+ New News', '/news/create'); ?>
</div>

<div id="single_column">
<table id="table_list_news" cellpadding="0" cellspacing="0" border="0" class="display">
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
    <?php for ($i = 0; $i < count($news); $i++) : ?>
    <?php $datetime = strtotime($news[$i]['News']['modified']);  ?>
    <tr>
        <td><?php echo $form->checkbox('News' . $news[$i]['News']['id'] . 'delete'); ?></td>
        <td><?php echo ($news[$i]['News']['subject']) ? $html->link($news[$i]['News']['subject'], '/news/edit/' . $news[$i]['News']['id']) : '-'; ?></td>
        <td><?php echo ($news[$i]['News']['modified']) ? date("M. d, Y", $datetime) : '-'; ?></td>
        <td><?php echo ($news[$i]['News']['modified']) ? date("H:i", $datetime) : '-'; ?></td>
        <td><?php echo $html->link('Edit', '/news/edit/' . $news[$i]['News']['id']); ?></td>
    </tr>
    <?php endfor; ?>
    </tbody>

</table>
</div>

<?php
    echo $form->end();
?>
