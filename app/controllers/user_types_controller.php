<?php

class UserTypesController extends AppController {

	var $name = 'UserTypes';
    var $belongsTo = 'User';


    function beforeFilter() {
        $this->disableCache();
        parent::beforeFilter();
    }
    
    function list_all() {
        return $this->find('list', array('fields' => array('UserType.title')));
    }

}

?>
