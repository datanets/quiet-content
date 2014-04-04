<?php
App::import('Sanitize');

class AnnouncementCategoriesController extends AppController
{
    var $name = 'AnnouncementCategories';
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
            $this->set('categories', $this->AnnouncementCategory->find('threaded',
                array('order' => 'lft')
            ));
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
            $this->set('categories', $this->AnnouncementCategory->find('threaded',
                array('order' => 'lft')
            ));
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
            $category_root = $this->AnnouncementCategory->find('first',
                array('conditions' => array('parent_id' => null))
            );
            $parent_id = $category_root['AnnouncementCategory']['id'];
            $new_item = array();
            $new_item['AnnouncementCategory']['parent_id'] = $parent_id;
            $new_item['AnnouncementCategory']['name'] = 'Untitled Category';

            $this->AnnouncementCategory->save($new_item);
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
                $this->AnnouncementCategory->id = $id;
                $this->AnnouncementCategory->save(array('parent_id' => $new_parent_id));

                // move to the bottom of the list first so we always start from bottom
                $this->AnnouncementCategory->moveDown($id, $total_li);     

                if ($move_up_total > 0)
                    $this->AnnouncementCategory->moveUp($id, $move_up_total);
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
            $this->AnnouncementCategory->id = $id;

            if (empty($this->data)) {
                $this->data = $this->AnnouncementCategory->find('first',
                    array(
                        'contain' => array(
                            'AnnouncementCategoryMenuItem' => array('order' => 'weight'),
                            'AnnouncementCategoryWidget'
                        ),
                        'conditions' => array('AnnouncementCategory.id' => $id)
                    )
                );

                $category_announcement_list = $this->AnnouncementCategory->find('all',
                    array(
                        'contain' => array('Announcement.id', 'Announcement.subject'),
                        'conditions' => array(
                            'lft >=' => $this->data['AnnouncementCategory']['lft'],
                            'rght <=' => $this->data['AnnouncementCategory']['rght']
                        ),
                    )
                );

                $category_announcement_list_array = array();

                // loop through and get a list of announcements under current category parent
                for ($i = 0; $i < count($category_announcement_list); $i++) {
                    for ($j = 0; $j < count($category_announcement_list[$i]['Announcement']); $j++) {
                        $category_announcement_list_array[$category_announcement_list[$i]['Announcement'][$j]['id']] = $category_announcement_list[$i]['Announcement'][$j]['subject'];
                    }
                }

                $this->set('announcement_category_types', $this->AnnouncementCategory->AnnouncementCategoryType->list_all());
                $this->set('announcement_category_widgets', $this->AnnouncementCategory->AnnouncementCategoryWidget->list_all());
                $this->set('announcement_category_list', $category_announcement_list_array);

                $dummy_item_add_label =  '<li class="menu_label" style="background-color:#aaa;">'
                                        .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_label temporary temporary_0" onclick="return false;">Delete</a></div>'
                                        .'<div style="padding:10px;padding-top:0;">'
                                        .'<label>Label</label>'
                                        .'<input type="text" id="AnnouncementCategoryMenuItem0Title" name="data[AnnouncementCategoryMenuItem][0][title]" value="" />'
                                        .'<input type="hidden" id="AnnouncementCategoryMenuItem0ItemType" name="data[AnnouncementCategoryMenuItem][0][item_type]" value="1" />'
                                        .'<div class="weight_box">'
                                        .'<input type="hidden" id="AnnouncementCategoryMenuItem0Weight" name="data[AnnouncementCategoryMenuItem][0][weight]" value="1" />'
                                        .'</div>'
                                        .'</div>'
                                        .'</li>';

                $dummy_item_add_link =   '<li class="menu_label">'
                                        .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_link temporary temporary_0" onclick="return false;">Delete</a></div>'
                                        .'<div style="padding:10px;padding-top:0;">'
                                        .'<label>Announcement Link</label>'
                                        .'<select name="data[AnnouncementCategoryMenuItem][0][link]" id="AnnouncementCategoryMenuItem0Link">'
                                        .'<option value=""></option>';

                                        foreach ($category_announcement_list_array as $k => $v) {
                                            $dummy_item_add_link .= '<option value="' . $k . '">' . $v . '</option>';
                                        }

                $dummy_item_add_link .=  '</select>'
                                        .'<input type="hidden" id="AnnouncementCategoryMenuItem0ItemType" name="data[AnnouncementCategoryMenuItem][0][item_type]" value="2" />'
                                        .'<div class="weight_box">'
                                        .'<input type="hidden" id="AnnouncementCategoryMenuItem0Weight" name="data[AnnouncementCategoryMenuItem][0][weight]" value="1" />'
                                        .'</div>'
                                        .'<div style="padding-top:10px;font-size:x-small;"><a href="' . $this->webroot . $this->params['url']['url'] . '#have_another_link_to_use" class="have_another_link_to_use">Have another link to use?</a></div>'
                                        .'<div class="category_menu_other_link_box">'
                                        .'<label>Link Text</label><input type="text" id="AnnouncementCategoryMenuItem0OtherLinkText" name="data[AnnouncementCategoryMenuItem][0][other_link_text]" value="" style="width:300px;" />'
                                        .'<label>Link Address</label><input type="text" id="AnnouncementCategoryMenuItem0OtherLink" name="data[AnnouncementCategoryMenuItem][0][other_link]" value="" style="width:300px;" />'
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
                    $this->AnnouncementCategory->AnnouncementCategoryMenuItem->delete($item_id);
                }

                foreach ($delete_these_links as $item) {
                    $item_id = Sanitize::escape($item);
                    $this->AnnouncementCategory->AnnouncementCategoryMenuItem->delete($item_id);
                }

                if ($this->AnnouncementCategory->saveAll($this->data)) {
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
                $this->AnnouncementCategory->id = $id;
                $this->AnnouncementCategory->save(array('name' => $new_name));
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

            if ($this->AnnouncementCategory->delete($id)) {
                $this->AnnouncementCategory->reorder();
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
        
        $id = Sanitize::escape($id);
        $website_preferences = $this->Preference->find('first');
        $parent_item = $this->AnnouncementCategory->find('first',
            array('conditions' => array('AnnouncementCategory.id' => $id))
        );
        $categories = $this->AnnouncementCategory->find('threaded',
            array(
                'conditions' => array(
                    'AnnouncementCategory.lft >=' => $parent_item['AnnouncementCategory']['lft'],
                    'AnnouncementCategory.rght <=' => $parent_item['AnnouncementCategory']['rght']
                )
            )
        );

        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : Announcement');
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('categories', $categories);
   }
}
?>
