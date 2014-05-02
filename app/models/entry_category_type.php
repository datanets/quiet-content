<?php
class EntryCategoryType extends AppModel
{
    var $name = 'EntryCategoryType';
    var $belongsTo = array(
        'EntryCategory' => array(
            'className' => 'EntryCategory',
            'foreignKey' => 'entry_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $actsAs = array('Containable');

    function list_all()
    {
        return $this->find('list', array('order' => 'id'));
    }
}
?>
