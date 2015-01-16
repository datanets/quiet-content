<?php

class EntryCategoryWidget extends AppModel
{

    var $name = 'EntryCategoryWidget';

    var $belongsTo = array(
        'EntryCategory' => array(
            'className' => 'EntryCategory',
            'foreignKey' => 'widget_type',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    var $actsAs = array(
        'Containable'
    );

    function list_all()
    {
        return $this->find('list', array(
            'order' => 'id'
        ));
    }
}
?>
