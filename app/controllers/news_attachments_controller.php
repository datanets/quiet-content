<?php
class EntryAttachmentsController extends AppController
{
    var $name = 'EntryAttachments';
    var $scaffold;

    function beforeFilter()
    {
        $this->disableCache();
        parent::beforeFilter();
    }
}
?>
