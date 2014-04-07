<?php
class EntryImagesController extends AppController
{
    var $name = 'EntryImages';
    var $scaffold;

    function beforeFilter()
    {
        $this->disableCache();
        parent::beforeFilter();
    }
}
?>
