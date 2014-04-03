<?php
App::import('Sanitize');

class AdCategoriesController extends AppController
{
    var $name = 'AdCategories';
    var $layout = 'admin';
    var $helpers = array('Cache');
    var $cacheAction = array(
        'view' => '1 day'
    );

    function beforeFilter()
    {
        $this->disableCache();
        parent::beforeFilter();
    }

    function index()
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {
            $this->set('categories', $this->AdCategory->find('threaded', array('order' => 'lft')));
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function get_updated_categories()
    {
        $this->layout = 'ajax';

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {
            $this->set('categories', $this->AdCategory->find('threaded', array('order' => 'lft')));
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function create()
    {
        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {
            $category_root = $this->AdCategory->find('first', array('conditions' => array('parent_id' => null)));
            $parent_id = $category_root['AdCategory']['id'];

            $new_item = array();
            $new_item['AdCategory']['parent_id'] = $parent_id;
            $new_item['AdCategory']['name'] = 'Untitled Category';

            $this->AdCategory->save($new_item);
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function update()
    {
        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {
            $id = Sanitize::clean($_GET['id']);
            $new_parent_id = Sanitize::clean($_GET['new_parent_id']);
            $move_up_total = Sanitize::clean($_GET['move_up_total']);
            $total_li = Sanitize::clean($_GET['total_li']);

            $id = str_replace('item_', '', $id);
            $new_parent_id = str_replace('item_', '', $new_parent_id);
            $move_up_total = intval($move_up_total);
            $total_li = intval($total_li);

            if ($id && $new_parent_id) {
                $this->AdCategory->id = $id;
                $this->AdCategory->save(array('parent_id' => $new_parent_id));
                $this->AdCategory->moveDown($id, $total_li);     # move to the bottom of the list first so we always start from bottom

                if ($move_up_total > 0)
                    $this->AdCategory->moveUp($id, $move_up_total);
                #else
                #    $this->AdCategory->moveDown($id, $total_li);     # move to the bottom of the list if needed
            }
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function edit($id = null)
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {
            $id = Sanitize::clean($id);
            $this->AdCategory->id = $id;

            if (empty($this->data)) {
                $this->data = $this->AdCategory->find('first',
                    array(
                        'contain' => array(
                            'AdCategoryMenuItem' => array('order' => 'weight'),
                            'AdCategoryWidget'
                        ),
                        'conditions' => array('AdCategory.id' => $id)
                    )
                );

                $category_ad_list = $this->AdCategory->find('all',
                    array(
                        'contain' => array('Ad.id', 'Ad.subject'),
                        'conditions' => array(
                            'lft >=' => $this->data['AdCategory']['lft'],
                            'rght <=' => $this->data['AdCategory']['rght']
                        ),
                    )
                );

                $category_ad_list_array = array();

                // loop through and get a list of ads under current category parent
                for ($i = 0; $i < count($category_ad_list); $i++) {
                    for ($j = 0; $j < count($category_ad_list[$i]['Ad']); $j++) {
                        $category_ad_list_array[$category_ad_list[$i]['Ad'][$j]['id']] = $category_ad_list[$i]['Ad'][$j]['subject'];
                    }
                }

                $this->set('ad_category_types', $this->AdCategory->AdCategoryType->list_all());
                $this->set('ad_category_widgets', $this->AdCategory->AdCategoryWidget->list_all());
                $this->set('ad_category_list', $category_ad_list_array);



                $dummy_item_add_label =  '<li class="menu_label" style="background-color:#aaa;">'
                                        .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_label temporary temporary_0" onclick="return false;">Delete</a></div>'
                                        .'<div style="padding:10px;padding-top:0;">'
                                        .'<label>Label</label>'
                                        .'<input type="text" id="AdCategoryMenuItem0Title" name="data[AdCategoryMenuItem][0][title]" value="" />'
                                        .'<input type="hidden" id="AdCategoryMenuItem0ItemType" name="data[AdCategoryMenuItem][0][item_type]" value="1" />'
                                        .'<div class="weight_box">'
                                        .'<input type="hidden" id="AdCategoryMenuItem0Weight" name="data[AdCategoryMenuItem][0][weight]" value="1" />'
                                        .'</div>'
                                        .'</div>'
                                        .'</li>';



                $dummy_item_add_link =   '<li class="menu_label">'
                                        .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_link temporary temporary_0" onclick="return false;">Delete</a></div>'
                                        .'<div style="padding:10px;padding-top:0;">'
                                        .'<label>Ad Link</label>'
                                        .'<select name="data[AdCategoryMenuItem][0][link]" id="AdCategoryMenuItem0Link">'
                                        .'<option value=""></option>';

                                        foreach ($category_ad_list_array as $k => $v) {
                                            $dummy_item_add_link .= '<option value="' . $k . '">' . $v . '</option>';
                                        }

                $dummy_item_add_link .=  '</select>'
                                        .'<input type="hidden" id="AdCategoryMenuItem0ItemType" name="data[AdCategoryMenuItem][0][item_type]" value="2" />'
                                        .'<div class="weight_box">'
                                        .'<input type="hidden" id="AdCategoryMenuItem0Weight" name="data[AdCategoryMenuItem][0][weight]" value="1" />'
                                        .'</div>'
                                        .'<div style="padding-top:10px;font-size:x-small;"><a href="' . $this->webroot . $this->params['url']['url'] . '#have_another_link_to_use" class="have_another_link_to_use">Have another link to use?</a></div>'
                                        .'<div class="category_menu_other_link_box">'
                                        .'<label>Link Text</label><input type="text" id="AdCategoryMenuItem0OtherLinkText" name="data[AdCategoryMenuItem][0][other_link_text]" value="" style="width:300px;" />'
                                        .'<label>Link Address</label><input type="text" id="AdCategoryMenuItem0OtherLink" name="data[AdCategoryMenuItem][0][other_link]" value="" style="width:300px;" />'
                                        .'</div>'
                                        .'</div>'
                                        .'</li>';
     

                $this->set('dummy_item_add_label', $dummy_item_add_label);
                $this->set('dummy_item_add_link', $dummy_item_add_link);
            } else {
                // check for category menu items to delete
                $delete_these_labels = split(',', $_POST['delete_these_labels']);
                $delete_these_links = split(',', $_POST['delete_these_links']);

                foreach ($delete_these_labels as $item) {
                    $item_id = Sanitize::escape($item);
                    $this->AdCategory->AdCategoryMenuItem->delete($item_id);
                }

                foreach ($delete_these_links as $item) {
                    $item_id = Sanitize::escape($item);
                    $this->AdCategory->AdCategoryMenuItem->delete($item_id);
                }

                if ($this->AdCategory->saveAll($this->data)) {
                    $this->Session->setFlash('Your category has been updated.');
                    $this->redirect(array('action' => 'index'));
                }
            }
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function rename()
    {
        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {
            $id = Sanitize::clean($_GET['id']);
            $new_name = Sanitize::clean($_GET['new_name']);

            $id = str_replace('item_', '', $id);

            if (($id && $new_name) && $new_name > '') {
                $this->AdCategory->id = $id;
                $this->AdCategory->save(array('name' => $new_name));
            }
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function delete($id = null)
    {
        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {
            $id = Sanitize::clean($id);
            if ($this->AdCategory->delete($id)) {
                $this->AdCategory->reorder();
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

    function view($id = null)
    {
        $this->layout = 'public';
        $website_preferences = $this->Preference->find('first');
        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : Ad');

        $id = Sanitize::escape($id);
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $parent_item = $this->AdCategory->find('first',
            array(
                'conditions' => array('AdCategory.id' => $id)
            )
        );

        $categories = $this->AdCategory->find('threaded',
            array(
                'conditions' => array(
                    'AdCategory.lft >=' => $parent_item['AdCategory']['lft'],
                    'AdCategory.rght <=' => $parent_item['AdCategory']['rght']
                )
            )
        );

        $this->set('categories', $categories);
   }
}
?>
