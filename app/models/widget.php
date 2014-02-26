<?php

class Widget extends AppModel {

	var $name = 'Widget';

    var $belongsTo = array(
        'Preference' => array(
            'className' => 'Preference',
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
