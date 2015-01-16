<?php

class EntryCategory extends AppModel
{

    var $name = 'EntryCategory';

    var $hasOne = array(
        'EntryCategoryType' => array(
            'foreignKey' => 'id',
            'type' => 'LEFT',
            'fields' => ' '
        ),
        'EntryCategoryWidget' => array(
            'foreignKey' => 'id',
            'type' => 'LEFT',
            'fields' => ' '
        )
    );

    var $hasMany = array(
        'Entry' => array(
            'foreignKey' => 'entry_category_id',
            'type' => 'INNER',
            'order' => 'Entry.subject',
            'conditions' => array(
                'Entry.status_id' => '1',
                'Entry.blank_page' => '0'
            )
        ),
        'EntryCategoryMenuItem' => array(
            'foreignKey' => 'category_menu_id',
            'type' => 'LEFT',
            'order' => 'EntryCategoryMenuItem.weight'
        )
    );

    var $actsAs = array(
        'Containable',
        'Tree'
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

    function list_all()
    {
        return $this->find('list', array(
            'order' => 'lft'
        ));
    }

    function list_nav_categories()
    {
        $category_root_array = $this->find('first', array(
            'conditions' => array(
                'parent_id' => null
            )
        ));
        $category_root_id = $category_root_array['EntryCategory']['id'];
        $main_result_array = $this->find('all', array(
            'conditions' => array(
                'parent_id' => $category_root_id
            ),
            'order' => 'lft',
            'contain' => array(
                'EntryCategoryMenuItem'
            )
        ));
        
        // find all entries that are in category menus
        $category_menu_entries_list = array();
        for ($i = 0; $i < count($main_result_array); $i ++) {
            if (isset($main_result_array[$i]['EntryCategoryMenuItem']) && count($main_result_array[$i]['EntryCategoryMenuItem']) > 0) {
                foreach ($main_result_array[$i]['EntryCategoryMenuItem'] as $item) {
                    if ($item['item_type'] == 2) {
                        array_push($category_menu_entries_list, $item['link']);
                    }
                }
            }
        }
        
        $entries = $this->Entry->find('all', array(
            'conditions' => array(
                'Entry.id' => $category_menu_entries_list,
                'Entry.status_id' => '1'
            ),
            'fields' => array(
                'id',
                'subject'
            ),
            'contain' => array()
        ));
        
        $entries_array = array();
        for ($i = 0; $i < count($entries); $i ++) {
            $entries_array[$entries[$i]['Entry']['id']] = $entries[$i]['Entry']['subject'];
        }
        
        $final_result_array = array();
        
        // last array item is a list of stories and ids
        array_push($final_result_array, $main_result_array, $entries_array);
        
        return $final_result_array;
    }

    function list_side_nav_categories()
    {
        $category_root_array = $this->find('first', array(
            'conditions' => array(
                'parent_id' => null
            )
        ));
        $category_root_id = $category_root_array['EntryCategory']['id'];
        
        return $this->find('all', array(
            'conditions' => array(
                'parent_id' => $category_root_id
            ),
            'order' => 'lft'
        ));
    }
}
?>
