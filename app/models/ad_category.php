<?php
class AdCategory extends AppModel
{
    var $name = 'AdCategory';
    var $hasMany = array('Ad' => array(
        'foreignKey' => 'ad_category_id',
        'type' => 'INNER',
        'order' => 'Ad.subject',
        'conditions' => array('Ad.status_id' => '1')
    ));
    var $actsAs = array('Containable', 'Tree');

    function list_all()
    {
        return $this->find('list', array('order' => 'lft'));
    }

    function list_nav_categories()
    {
        $category_root_array = $this->find('first',
            array('conditions' => array('parent_id' => null))
        );
        $category_root_id = $category_root_array['AdCategory']['id'];

        $main_result_array = $this->find('all',
            array(
                'conditions' => array(
                    'parent_id' => $category_root_id
                ),
                'order' => 'lft',
                'contain' => array('AdCategoryMenuItem')
            )
        );

        // find all ads that are in category menus
        $category_menu_ads_list = array();
        for ($i = 0; $i < count($main_result_array); $i++) {
            if (isset($main_result_array[$i]['AdCategoryMenuItem']) && count($main_result_array[$i]['AdCategoryMenuItem']) > 0) {
                foreach ($main_result_array[$i]['AdCategoryMenuItem'] as $item) {
                    if ($item['item_type'] == 2) {
                        array_push($category_menu_ads_list, $item['link']);
                    }
                }
            }
        }

        $ads = $this->Ad->find('all',
            array(
                'conditions' => array(
                    'Ad.id' => $category_menu_ads_list,
                    'Ad.status_id' => '1'
                ),
                'fields' => array('id', 'subject'),
                'contain' => array()
            )
        );

        $ads_array = array();
        for ($i = 0; $i < count($ads); $i++) {
            $ads_array[$ads[$i]['Ad']['id']] = $ads[$i]['Ad']['subject'];
        }

        $final_result_array = array();

        // last array item is a list of stories and ids
        array_push($final_result_array, $main_result_array, $ads_array);

        return $final_result_array;
    }

    function list_side_nav_categories()
    {
        $category_root_array = $this->find('first',
            array('conditions' => array('parent_id' => null))
        );
        $category_root_id = $category_root_array['AdCategory']['id'];

        return $this->find('all',
            array(
                'conditions' => array(
                    'parent_id' => $category_root_id
                ),
                'order' => 'lft'
            )
        );
    }
}
?>
