<?php
App::import('Sanitize');

class EntryCategoriesController extends AppController
{

    var $name = 'EntryCategories';

    var $layout = 'admin';

    var $helpers = array(
        'Cache'
    );

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
            $this->set('categories', $this->EntryCategory->find('threaded', array(
                'order' => 'lft'
            )));
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
            $this->set('categories', $this->EntryCategory->find('threaded', array(
                'order' => 'lft'
            )));
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
            $category_root = $this->EntryCategory->find('first', array(
                'conditions' => array(
                    'parent_id' => null
                )
            ));
            $parent_id = $category_root['EntryCategory']['id'];
            $new_item = array();
            $new_item['EntryCategory']['parent_id'] = $parent_id;
            $new_item['EntryCategory']['name'] = 'Untitled Category';
            
            $this->EntryCategory->save($new_item);
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
                $this->EntryCategory->id = $id;
                $this->EntryCategory->save(array(
                    'parent_id' => $new_parent_id
                ));
                
                // move to the bottom of the list first so we always start from bottom
                $this->EntryCategory->moveDown($id, $total_li);
                
                if ($move_up_total > 0)
                    $this->EntryCategory->moveUp($id, $move_up_total);
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
            $this->EntryCategory->id = $id;
            
            if (empty($this->data)) {
                $this->data = $this->EntryCategory->find('first', array(
                    'contain' => array(
                        'EntryCategoryMenuItem' => array(
                            'order' => 'weight'
                        ),
                        'EntryCategoryWidget'
                    ),
                    'conditions' => array(
                        'EntryCategory.id' => $id
                    )
                ));
                
                $category_entry_list = $this->EntryCategory->find('all', array(
                    'contain' => array(
                        'Entry.id',
                        'Entry.subject'
                    ),
                    'conditions' => array(
                        'lft >=' => $this->data['EntryCategory']['lft'],
                        'rght <=' => $this->data['EntryCategory']['rght']
                    )
                ));
                
                $category_entry_list_array = array();
                
                // loop through and get a list of entries under current category parent
                for ($i = 0; $i < count($category_entry_list); $i ++) {
                    for ($j = 0; $j < count($category_entry_list[$i]['Entry']); $j ++) {
                        $category_entry_list_array[$category_entry_list[$i]['Entry'][$j]['id']] = $category_entry_list[$i]['Entry'][$j]['subject'];
                    }
                }
                
                $this->set('entry_category_types', $this->EntryCategory->EntryCategoryType->list_all());
                $this->set('entry_category_widgets', $this->EntryCategory->EntryCategoryWidget->list_all());
                $this->set('entry_category_list', $category_entry_list_array);
                
                $entry_category_menu_items = $this->data['EntryCategoryMenuItem'];
                $highest_menu_item_id = 0;
                foreach ($entry_category_menu_items as $k => $v) {
                    if ($v['id'] > $highest_menu_item_id)
                        $highest_menu_item_id = $v['id'];
                }
                $this->set('highest_menu_item_id', $highest_menu_item_id);
                
                $dummy_item_add_label = '<li class="menu_label" style="background-color:#aaa;">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_label temporary temporary_0" onclick="return false;">Delete</a></div>' . '<div style="padding:10px;padding-top:0;">' . '<label>Label</label>' . '<input type="text" id="EntryCategoryMenuItem0Title" name="data[EntryCategoryMenuItem][0][title]" value="" />' . '<input type="hidden" id="EntryCategoryMenuItem0ItemType" name="data[EntryCategoryMenuItem][0][item_type]" value="1" />' . '<div class="weight_box">' . '<input type="hidden" id="EntryCategoryMenuItem0Weight" name="data[EntryCategoryMenuItem][0][weight]" value="1" />' . '</div>' . '</div>' . '</li>';
                
                $dummy_item_add_link = '<li class="menu_label">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_link temporary temporary_0" onclick="return false;">Delete</a></div>' . '<div style="padding:10px;padding-top:0;">' . '<label>Entry Link</label>' . '<select name="data[EntryCategoryMenuItem][0][link]" id="EntryCategoryMenuItem0Link">' . '<option value=""></option>';
                
                foreach ($category_entry_list_array as $k => $v) {
                    $dummy_item_add_link .= '<option value="' . $k . '">' . $v . '</option>';
                }
                
                $dummy_item_add_link .= '</select>' . '<input type="hidden" id="EntryCategoryMenuItem0ItemType" name="data[EntryCategoryMenuItem][0][item_type]" value="2" />' . '<div class="weight_box">' . '<input type="hidden" id="EntryCategoryMenuItem0Weight" name="data[EntryCategoryMenuItem][0][weight]" value="1" />' . '</div>' . '<div style="padding-top:10px;font-size:x-small;"><a href="' . $this->webroot . $this->params['url']['url'] . '#have_another_link_to_use" class="have_another_link_to_use">Have another link to use?</a></div>' . '<div class="category_menu_other_link_box">' . '<label>Link Text</label><input type="text" id="EntryCategoryMenuItem0OtherLinkText" name="data[EntryCategoryMenuItem][0][other_link_text]" value="" style="width:300px;" />' . '<label>Link Address</label><input type="text" id="EntryCategoryMenuItem0OtherLink" name="data[EntryCategoryMenuItem][0][other_link]" value="" style="width:300px;" />' . '</div>' . '</div>' . '</li>';
                
                $this->set('dummy_item_add_label', $dummy_item_add_label);
                $this->set('dummy_item_add_link', $dummy_item_add_link);
            } else {
                // check for category menu items to delete
                $delete_these_labels = split(',', $_POST['delete_these_labels']);
                $delete_these_links = split(',', $_POST['delete_these_links']);
                
                foreach ($delete_these_labels as $item) {
                    $item_id = Sanitize::escape($item);
                    $this->EntryCategory->EntryCategoryMenuItem->delete($item_id);
                }
                
                foreach ($delete_these_links as $item) {
                    $item_id = Sanitize::escape($item);
                    $this->EntryCategory->EntryCategoryMenuItem->delete($item_id);
                }
                
                if ($this->EntryCategory->saveAll($this->data)) {
                    $this->Session->setFlash('Your category has been updated.');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
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
                $this->EntryCategory->id = $id;
                $this->EntryCategory->save(array(
                    'name' => $new_name
                ));
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
            
            if ($this->EntryCategory->delete($id)) {
                // delete related entry_category_menu_items
                $this->EntryCategory->query("delete from entry_category_menu_items where category_menu_id = $id");
                $this->Session->setFlash('Your category has been deleted.');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash('Sorry, the category could not be deleted.');
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function view($id = null)
    {
        $this->layout = 'public';
        $id = Sanitize::escape($id);
        $website_preferences = $this->Preference->find('first');
        $parent_item = $this->EntryCategory->find('first', array(
            'conditions' => array(
                'EntryCategory.id' => $id
            )
        ));
        $categories = $this->EntryCategory->find('threaded', array(
            'conditions' => array(
                'EntryCategory.lft >=' => $parent_item['EntryCategory']['lft'],
                'EntryCategory.rght <=' => $parent_item['EntryCategory']['rght']
            ),
            'order' => 'EntryCategory.lft'
        ));
        
        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : Featured Entries');
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('categories', $categories);
        
        // Now we need to find featured entries for this category
        $this->EntryCategory->contain();
        $just_categories = $this->EntryCategory->find('all', array(
            'conditions' => array(
                'EntryCategory.lft >=' => $parent_item['EntryCategory']['lft'],
                'EntryCategory.rght <=' => $parent_item['EntryCategory']['rght']
            ),
            'order' => 'EntryCategory.lft'
        ));
        
        // Find what categories are within the bounds of lft and rght of current main category
        $valid_category_ids_array = array();
        foreach ($just_categories as $item) {
            array_push($valid_category_ids_array, $item['EntryCategory']['id']);
        }
        
        $featured = $this->EntryCategory->Entry->find('all', array(
            'conditions' => array(
                'Entry.cat_featured_entry' => '1',
                'Entry.blank_page' => '0'
            ),
            'order' => 'Entry.id'
        ));
        
        // Then we need to really find what entries should be featured for this particular category
        $final_featured_array = array();
        foreach ($featured as $k => $v) {
            if (in_array($v['Entry']['entry_category_id'], $valid_category_ids_array))
                array_push($final_featured_array, $v['Entry']);
        }
        
        $this->set('featured', $final_featured_array);
    }
}
?>
