<?php

class AnnouncementCategory extends AppModel {

	var $name = 'AnnouncementCategory';

/*
    var $hasOne = array('AnnouncementCategoryType' => array( 'foreignKey' => 'id',
                                            'type' => 'LEFT',
                                            'fields' => ' ' ),
                        'AnnouncementCategoryWidget' => array( 'foreignKey' => 'id',
                                            'type' => 'LEFT',
                                            'fields' => ' ' )
                        );
*/

    var $hasMany = array('Announcement' => array( 'foreignKey' => 'announcement_category_id',
                                                  'type' => 'INNER',
                                                  'order' => 'Announcement.subject',
                                                  'conditions' => array('Announcement.status_id' => '1') ));
/*
                         'AnnouncementCategoryMenuItem' => array( 'foreignKey' => 'category_menu_id',
                                                  'type' => 'LEFT',
                                                  'order' => 'AnnouncementCategoryMenuItem.weight' )

                                              );
*/

    var $actsAs = array('Containable', 'Tree');


    function list_all() {
        return $this->find('list', array('order' => 'lft'));
    }

    function list_nav_categories() {

        $category_root_array = $this->find('first', array('conditions' => array('parent_id' => null)));
        $category_root_id = $category_root_array['AnnouncementCategory']['id'];

        $main_result_array = $this->find('all', array('conditions' => array('parent_id' => $category_root_id), 'order' => 'lft',
                                        'contain' => array('AnnouncementCategoryMenuItem')));


        // find all announcements that are in category menus
        $category_menu_announcements_list = array();
        for ($i = 0; $i < count($main_result_array); $i++) {

            if (isset($main_result_array[$i]['AnnouncementCategoryMenuItem']) && count($main_result_array[$i]['AnnouncementCategoryMenuItem']) > 0) {
                foreach ($main_result_array[$i]['AnnouncementCategoryMenuItem'] as $item) {
                    if ($item['item_type'] == 2) {
                        array_push($category_menu_announcements_list, $item['link']);
                    }
                }
            }

        }

        //$category_menu_announcements_string = implode(',', $category_menu_announcements_list);

        $announcements = $this->Announcement->find('all', array( 'conditions' => array(  'Announcement.id' => $category_menu_announcements_list,
                                                                            'Announcement.status_id' => '1'),
                                                    'fields' => array('id', 'subject'),
                                                    'contain' => array()));

        $announcements_array = array();
        for ($i = 0; $i < count($announcements); $i++) {
            $announcements_array[$announcements[$i]['Announcement']['id']] = $announcements[$i]['Announcement']['subject'];
        }

        $final_result_array = array();

        // last array item is a list of stories and ids
        array_push($final_result_array, $main_result_array, $announcements_array);

        return $final_result_array;

    }

    function list_side_nav_categories() {

        $category_root_array = $this->find('first', array('conditions' => array('parent_id' => null)));
        $category_root_id = $category_root_array['AnnouncementCategory']['id'];

        return $this->find('all', array('conditions' => array('parent_id' => $category_root_id), 'order' => 'lft'));
    }

}

?>
