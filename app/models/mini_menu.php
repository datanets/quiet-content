<?php

class MiniMenu extends AppModel {

	var $name = 'MiniMenu';

    var $hasMany = array('MiniMenuItem' => array( 'foreignKey' => 'mini_menu_id',
                                                  'type' => 'LEFT',
                                                  'order' => 'MiniMenuItem.weight' )
                                               );

    var $actsAs = array('Containable');


    function afterSave() {
        if (CACHE > '') {

            // sweep away old cache files because this is part of header
            $dir = CACHE.'views'.DS;
            if (!$dh = @opendir($dir)) return;
            while (false !== ($file = readdir($dh))) {
                if ($file == '.' || $file == '..' || $file == 'empty') continue;
                unlink ($dir.DS.$file);
            }
            closedir($dh);

        }
    }

    function afterDelete() {
        if (CACHE > '') {

            // sweep away old cache files because this is part of header
            $dir = CACHE.'views'.DS;
            if (!$dh = @opendir($dir)) return;
            while (false !== ($file = readdir($dh))) {
                if ($file == '.' || $file == '..' || $file == 'empty') continue;
                unlink ($dir.DS.$file);
            }
            closedir($dh);

        }
    }

    function list_all() {
        return $this->find('list', array('order' => 'id'));
    }

    function list_all_mini_menus() {
        return $this->find('all', array('order' => 'modified'));
    }
}

?>
