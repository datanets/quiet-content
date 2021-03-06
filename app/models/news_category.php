<?php

class NewsCategory extends AppModel
{

    var $name = 'NewsCategory';

    var $hasMany = array(
        'News' => array(
            'foreignKey' => 'news_category_id',
            'type' => 'INNER',
            'order' => 'News.subject',
            'conditions' => array(
                'News.status_id' => '1'
            )
        )
    );

    var $actsAs = array(
        'Containable',
        'Tree'
    );

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
        $category_root_id = $category_root_array['NewsCategory']['id'];
        $main_result_array = $this->find('all', array(
            'conditions' => array(
                'parent_id' => $category_root_id
            ),
            'order' => 'lft',
            'contain' => array(
                'NewsCategoryMenuItem'
            )
        ));
        
        // find all news that are in category menus
        $category_menu_news_list = array();
        for ($i = 0; $i < count($main_result_array); $i ++) {
            if (isset($main_result_array[$i]['NewsCategoryMenuItem']) && count($main_result_array[$i]['NewsCategoryMenuItem']) > 0) {
                foreach ($main_result_array[$i]['NewsCategoryMenuItem'] as $item) {
                    if ($item['item_type'] == 2) {
                        array_push($category_menu_news_list, $item['link']);
                    }
                }
            }
        }
        
        $news = $this->News->find('all', array(
            'conditions' => array(
                'News.id' => $category_menu_news_list,
                'News.status_id' => '1'
            ),
            'fields' => array(
                'id',
                'subject'
            ),
            'contain' => array()
        ));
        
        $news_array = array();
        for ($i = 0; $i < count($news); $i ++) {
            $news_array[$news[$i]['News']['id']] = $news[$i]['News']['subject'];
        }
        
        $final_result_array = array();
        
        // last array item is a list of stories and ids
        array_push($final_result_array, $main_result_array, $news_array);
        
        return $final_result_array;
    }

    function list_side_nav_categories()
    {
        $category_root_array = $this->find('first', array(
            'conditions' => array(
                'parent_id' => null
            )
        ));
        $category_root_id = $category_root_array['NewsCategory']['id'];
        
        return $this->find('all', array(
            'conditions' => array(
                'parent_id' => $category_root_id
            ),
            'order' => 'lft'
        ));
    }
}
?>
