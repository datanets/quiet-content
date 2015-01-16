<?php

class Preference extends AppModel
{

    var $name = 'Preference';

    var $hasMany = array(
        'Widget' => array(
            'foreignKey' => 'preference_id',
            'type' => 'INNER',
            'order' => 'Widget.title'
        )
    );

    function afterSave()
    {
        if (CACHE > '') {
            // sweep away old cache files because this is part of header
            $dir = CACHE . 'views' . DS;
            if (! $dh = @opendir($dir))
                return;
            while (false !== ($file = readdir($dh))) {
                if ($file == '.' || $file == '..' || $file == 'empty')
                    continue;
                unlink($dir . DS . $file);
            }
            closedir($dh);
        }
    }

    function afterDelete()
    {
        if (CACHE > '') {
            // sweep away old cache files because this is part of header
            $dir = CACHE . 'views' . DS;
            if (! $dh = @opendir($dir))
                return;
            while (false !== ($file = readdir($dh))) {
                if ($file == '.' || $file == '..' || $file == 'empty')
                    continue;
                unlink($dir . DS . $file);
            }
            closedir($dh);
        }
    }
}
?>
