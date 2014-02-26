<?php

class TagsController extends AppController {

	var $name = 'Tags';
	var $scaffold;


    function beforeFilter() {
        $this->disableCache();
        parent::beforeFilter();
    }

}

?>
