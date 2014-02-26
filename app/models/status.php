<?php

class Status extends AppModel {

	var $name = 'Status';
    var $belongsTo = 'Entry';
	var $displayField = 'name';

    function list_all() {
        return $this->find('list', array('order' => 'name ASC'));
    }

}

?>
