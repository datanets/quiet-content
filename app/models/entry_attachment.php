<?php

class EntryAttachment extends AppModel
{

    var $name = 'EntryAttachment';

    var $displayField = 'name';

    var $belongsTo = array(
        'Entry' => array(
            'className' => 'Entry',
            'foreignKey' => 'entry_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}
?>
