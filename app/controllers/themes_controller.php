<?php
class ThemesController extends AppController
{
    var $name = 'Themes';
    var $scaffold;

    function beforeFilter()
    {
        $this->disableCache();
        parent::beforeFilter();
    }
}
?>
