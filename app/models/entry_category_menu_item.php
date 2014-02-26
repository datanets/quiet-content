<?php

class EntryCategoryMenuItem extends AppModel {

	var $name = 'EntryCategoryMenuItem';

    var $belongsTo = array(
        'EntryCategory' => array(
            'className' => 'EntryCategoryMenu',
            'foreignKey' => 'id',
            //'foreignKey' => 'entry_category_menu_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    var $actsAs = array('Containable');

}

?>
