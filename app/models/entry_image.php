<?php

class EntryImage extends AppModel
{

    var $name = 'EntryImage';

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
