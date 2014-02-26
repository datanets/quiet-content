<?php

App::import('Sanitize');

class NewsCategoriesController extends AppController {

	var $name = 'NewsCategories';
    var $layout = 'admin';
    var $helpers = array('Cache');
    var $cacheAction = array(
        'view' => '1 day'
    );


    function beforeFilter() {
        $this->disableCache();
        parent::beforeFilter();
    }

    function index() {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $this->set('categories', $this->NewsCategory->find('threaded', array('order' => 'lft')));

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function get_updated_categories() {

        $this->layout = 'ajax';

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $this->set('categories', $this->NewsCategory->find('threaded', array('order' => 'lft')));

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function create() {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $category_root = $this->NewsCategory->find('first', array('conditions' => array('parent_id' => null)));
            $parent_id = $category_root['NewsCategory']['id'];

            $new_item = array();
            $new_item['NewsCategory']['parent_id'] = $parent_id;
            $new_item['NewsCategory']['name'] = 'Untitled Category';

            $this->NewsCategory->save($new_item);

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function update() {
    
        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            #echo 'updating...' . '<br>';
            #debug($_GET, true);
            #exit;

            $id = Sanitize::clean($_GET['id']);
            $new_parent_id = Sanitize::clean($_GET['new_parent_id']);
            $move_up_total = Sanitize::clean($_GET['move_up_total']);
            $total_li = Sanitize::clean($_GET['total_li']);

            $id = str_replace('item_', '', $id);
            $new_parent_id = str_replace('item_', '', $new_parent_id);
            $move_up_total = intval($move_up_total);
            $total_li = intval($total_li);


            if ($id && $new_parent_id) {
                $this->NewsCategory->id = $id;
                $this->NewsCategory->save(array('parent_id' => $new_parent_id));
                $this->NewsCategory->moveDown($id, $total_li);     # move to the bottom of the list first so we always start from bottom

                if ($move_up_total > 0)
                    $this->NewsCategory->moveUp($id, $move_up_total);
                #else
                #    $this->NewsCategory->moveDown($id, $total_li);     # move to the bottom of the list if needed
            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function edit($id = null) {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $id = Sanitize::clean($id);
            $this->NewsCategory->id = $id;

            if (empty($this->data)) {

                $this->data = $this->NewsCategory->find('first',
                                                    array(  'contain' => array( 'NewsCategoryMenuItem' => array('order' => 'weight'),
                                                                                'NewsCategoryWidget'),
                                                            'conditions' => array('NewsCategory.id' => $id)));

                $category_news_list = $this->NewsCategory->find(  'all', array('contain' => array('News.id', 'News.subject'),
                                                                    'conditions' => array('lft >=' => $this->data['NewsCategory']['lft'],
                                                                                           'rght <=' => $this->data['NewsCategory']['rght']),
                                                                    ));

                $category_news_list_array = array();

                // loop through and get a list of newss under current category parent
                for ($i = 0; $i < count($category_news_list); $i++) {
                    for ($j = 0; $j < count($category_news_list[$i]['News']); $j++) {
                        $category_news_list_array[$category_news_list[$i]['News'][$j]['id']] = $category_news_list[$i]['News'][$j]['subject'];
                    }
                }

                $this->set('news_category_types', $this->NewsCategory->NewsCategoryType->list_all());
                $this->set('news_category_widgets', $this->NewsCategory->NewsCategoryWidget->list_all());
                $this->set('news_category_list', $category_news_list_array);



                $dummy_item_add_label =  '<li class="menu_label" style="background-color:#aaa;">'
                                        .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_label temporary temporary_0" onclick="return false;">Delete</a></div>'
                                        .'<div style="padding:10px;padding-top:0;">'
                                        .'<label>Label</label>'
                                        .'<input type="text" id="NewsCategoryMenuItem0Title" name="data[NewsCategoryMenuItem][0][title]" value="" />'
                                        .'<input type="hidden" id="NewsCategoryMenuItem0ItemType" name="data[NewsCategoryMenuItem][0][item_type]" value="1" />'
                                        .'<div class="weight_box">'
                                        .'<input type="hidden" id="NewsCategoryMenuItem0Weight" name="data[NewsCategoryMenuItem][0][weight]" value="1" />'
                                        .'</div>'
                                        .'</div>'
                                        .'</li>';



                $dummy_item_add_link =   '<li class="menu_label">'
                                        .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_link temporary temporary_0" onclick="return false;">Delete</a></div>'
                                        .'<div style="padding:10px;padding-top:0;">'
                                        .'<label>News Link</label>'
                                        .'<select name="data[NewsCategoryMenuItem][0][link]" id="NewsCategoryMenuItem0Link">'
                                        .'<option value=""></option>';

                                        foreach ($category_news_list_array as $k => $v) {
                                            $dummy_item_add_link .= '<option value="' . $k . '">' . $v . '</option>';
                                        }

                $dummy_item_add_link .=  '</select>'
                                        .'<input type="hidden" id="NewsCategoryMenuItem0ItemType" name="data[NewsCategoryMenuItem][0][item_type]" value="2" />'
                                        .'<div class="weight_box">'
                                        .'<input type="hidden" id="NewsCategoryMenuItem0Weight" name="data[NewsCategoryMenuItem][0][weight]" value="1" />'
                                        .'</div>'
                                        .'<div style="padding-top:10px;font-size:x-small;"><a href="' . $this->webroot . $this->params['url']['url'] . '#have_another_link_to_use" class="have_another_link_to_use">Have another link to use?</a></div>'
                                        .'<div class="category_menu_other_link_box">'
                                        .'<label>Link Text</label><input type="text" id="NewsCategoryMenuItem0OtherLinkText" name="data[NewsCategoryMenuItem][0][other_link_text]" value="" style="width:300px;" />'
                                        .'<label>Link Address</label><input type="text" id="NewsCategoryMenuItem0OtherLink" name="data[NewsCategoryMenuItem][0][other_link]" value="" style="width:300px;" />'
                                        .'</div>'
                                        .'</div>'
                                        .'</li>';
     

                $this->set('dummy_item_add_label', $dummy_item_add_label);
                $this->set('dummy_item_add_link', $dummy_item_add_link);



                #echo '<br><br><br><br><br><br><pre>' . print_r($this->data, true) . '</pre>';
                #debug($category_news_list, true);
                #debug($category_news_list_array, true);

            } else {

                // check for category menu items to delete

                $delete_these_labels = split(',', $_POST['delete_these_labels']);
                $delete_these_links = split(',', $_POST['delete_these_links']);

                foreach ($delete_these_labels as $item) {

                    $item_id = Sanitize::escape($item);
                    $this->NewsCategory->NewsCategoryMenuItem->delete($item_id);

                }

                foreach ($delete_these_links as $item) {

                    $item_id = Sanitize::escape($item);
                    $this->NewsCategory->NewsCategoryMenuItem->delete($item_id);

                }


                if ($this->NewsCategory->saveAll($this->data)) {

                    $this->Session->setFlash('Your category has been updated.');
                    $this->redirect(array('action' => 'index'));

                }

            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function rename() {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $id = Sanitize::clean($_GET['id']);
            $new_name = Sanitize::clean($_GET['new_name']);

            $id = str_replace('item_', '', $id);

            if (($id && $new_name) && $new_name > '') {
                $this->NewsCategory->id = $id;
                $this->NewsCategory->save(array('name' => $new_name));
            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function delete($id = null) {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $id = Sanitize::clean($id);

            if ($this->NewsCategory->delete($id)) {

                $this->NewsCategory->reorder();

                $this->Session->setFlash('Your category has been deleted.');
                $this->redirect(array('action' => 'index'));

            } else {

                $this->Session->setFlash('Sorry, the category could not be deleted.');
                $this->redirect(array('action' => 'index'));

            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function view($id = null) {

        $this->layout = 'public';
        $website_preferences = $this->Preference->find('first');
        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : Featured News');

        $id = Sanitize::escape($id);

        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));

        //$categories = $this->NewsCategory->children(1);

        $parent_item = $this->NewsCategory->find('first', array('conditions' => array('NewsCategory.id' => $id)));

        $categories = $this->NewsCategory->find('threaded', array( 'conditions' => array(
                                                                        'NewsCategory.lft >=' => $parent_item['NewsCategory']['lft'],
                                                                        'NewsCategory.rght <=' => $parent_item['NewsCategory']['rght'] ) ));

        $this->set('categories', $categories);

   }

}

?>
