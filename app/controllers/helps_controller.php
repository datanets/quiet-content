<?php

class HelpsController extends AppController
{

    var $name = 'Helps';

    var $scaffold;

    function beforeFilter()
    {
        $this->disableCache();
        parent::beforeFilter();
    }
}
?>
