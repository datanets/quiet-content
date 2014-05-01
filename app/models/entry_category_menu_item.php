<?php
class EntryCategoryMenuItem extends AppModel
{
    var $name = 'EntryCategoryMenuItem';
    var $belongsTo = array(
        'EntryCategory' => array(
            'className' => 'EntryCategoryMenu',
            'foreignKey' => 'id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $actsAs = array('Containable');
}
?>
