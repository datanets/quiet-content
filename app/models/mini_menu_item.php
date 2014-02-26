<?php

class MiniMenuItem extends AppModel {

	var $name = 'MiniMenuItem';

    var $belongsTo = array(
        'MiniMenu' => array(
            'className' => 'MiniMenu',
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
