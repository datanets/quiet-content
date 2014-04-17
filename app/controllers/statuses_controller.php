<?php
class StatusesController extends AppController
{
    var $name = 'Statuses';
    var $scaffold;

    function beforeFilter()
    {
        $this->disableCache();
        parent::beforeFilter();
    }
}
?>
