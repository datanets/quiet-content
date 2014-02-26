<?php

App::import('Sanitize');

class MiniMenusController extends AppController {

	var $name = 'MiniMenus';
    var $layout = 'admin';


    function beforeFilter() {
        $this->disableCache();
        parent::beforeFilter();
    }

    function index() {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $this->MiniMenu->contain();
            $this->set('mini_menus', $this->MiniMenu->find('all', array('order' => 'id')));

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }
    }

    function create() {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $dummy_item_add_label =  '<li class="menu_label" style="background-color:#aaa;">'
                                    .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_label temporary temporary_0" onclick="return false;">Delete</a></div>'
                                    .'<div style="padding:10px;padding-top:0;">'
                                    .'<label>Label</label>'
                                    .'<input type="text" id="MiniMenuItem0Title" name="data[MiniMenuItem][0][title]" value="" />'
                                    .'<input type="hidden" id="MiniMenuItem0ItemType" name="data[MiniMenuItem][0][item_type]" value="1" />'
                                    .'<div class="weight_box">'
                                    .'<input type="hidden" id="MiniMenuItem0Weight" name="data[MiniMenuItem][0][weight]" value="1" />'
                                    .'</div>'
                                    .'</div>'
                                    .'</li>';



            $dummy_item_add_link =   '<li class="menu_label">'
                                    .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_link temporary temporary_0" onclick="return false;">Delete</a></div>'
                                    .'<div style="padding:10px;padding-top:0;">'
                                    .'<input type="hidden" id="MiniMenuItem0ItemType" name="data[MiniMenuItem][0][item_type]" value="2" />'
                                    .'<div class="weight_box">'
                                    .'<input type="hidden" id="MiniMenuItem0Weight" name="data[MiniMenuItem][0][weight]" value="1" />'
                                    .'</div>'
                                    //.'<div style="padding-top:10px;font-size:x-small;"><a href="' . $this->webroot . $this->params['url']['url'] . '#have_another_link_to_use" class="have_another_link_to_use">Have another link to use?</a></div>'
                                    .'<div class="category_menu_other_link_box" style="display:block;">'
                                    .'<label>Link Text</label><input type="text" id="MiniMenuItem0OtherLinkText" name="data[MiniMenuItem][0][other_link_text]" value="" style="width:300px;" />'
                                    .'<label>Link Address</label><input type="text" id="MiniMenuItem0OtherLink" name="data[MiniMenuItem][0][other_link]" value="" style="width:300px;" />'
                                    .'</div>'
                                    .'</div>'
                                    .'</li>';


            $this->set('dummy_item_add_label', $dummy_item_add_label);
            $this->set('dummy_item_add_link', $dummy_item_add_link);

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
            $this->MiniMenu->id = $id;

            if (empty($this->data)) {

                $this->data = $this->MiniMenu->find('first',
                                                    array(  'contain' => array( 'MiniMenuItem' => array('order' => 'weight')),
                                                            'conditions' => array('MiniMenu.id' => $id)));



                $mini_menu_items = $this->data['MiniMenuItem'];
                $highest_menu_item_id = 0;
                foreach ($mini_menu_items as $k => $v) {
                    if ($v['id'] > $highest_menu_item_id)
                        $highest_menu_item_id = $v['id'];
                }

                $this->set('highest_menu_item_id', $highest_menu_item_id);

                $dummy_item_add_label =  '<li class="menu_label" style="background-color:#aaa;">'
                                        .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_label temporary temporary_0" onclick="return false;">Delete</a></div>'
                                        .'<div style="padding:10px;padding-top:0;">'
                                        .'<label>Label</label>'
                                        .'<input type="text" id="MiniMenuItem0Title" name="data[MiniMenuItem][0][title]" value="" />'
                                        .'<input type="hidden" id="MiniMenuItem0ItemType" name="data[MiniMenuItem][0][item_type]" value="1" />'
                                        .'<div class="weight_box">'
                                        .'<input type="hidden" id="MiniMenuItem0Weight" name="data[MiniMenuItem][0][weight]" value="1" />'
                                        .'</div>'
                                        .'</div>'
                                        .'</li>';



                $dummy_item_add_link =   '<li class="menu_label">'
                                        .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_link temporary temporary_0" onclick="return false;">Delete</a></div>'
                                        .'<div style="padding:10px;padding-top:0;">'
                                        .'<input type="hidden" id="MiniMenuItem0ItemType" name="data[MiniMenuItem][0][item_type]" value="2" />'
                                        .'<div class="weight_box">'
                                        .'<input type="hidden" id="MiniMenuItem0Weight" name="data[MiniMenuItem][0][weight]" value="1" />'
                                        .'</div>'
                                        //.'<div style="padding-top:10px;font-size:x-small;"><a href="' . $this->webroot . $this->params['url']['url'] . '#have_another_link_to_use" class="have_another_link_to_use">Have another link to use?</a></div>'
                                        .'<div class="category_menu_other_link_box" style="display:block;">'
                                        .'<label>Link Text</label><input type="text" id="MiniMenuItem0OtherLinkText" name="data[MiniMenuItem][0][other_link_text]" value="" style="width:300px;" />'
                                        .'<label>Link Address</label><input type="text" id="MiniMenuItem0OtherLink" name="data[MiniMenuItem][0][other_link]" value="" style="width:300px;" />'
                                        .'</div>'
                                        .'</div>'
                                        .'</li>';
     

                $this->set('dummy_item_add_label', $dummy_item_add_label);
                $this->set('dummy_item_add_link', $dummy_item_add_link);



                #echo '<br><br><br><br><br><br><pre>' . print_r($this->data, true) . '</pre>';
                #debug($category_mini menu_list, true);
                #debug($category_mini menu_list_array, true);

            } else {

                // check for category menu items to delete

                $delete_these_labels = split(',', $_POST['delete_these_labels']);
                $delete_these_links = split(',', $_POST['delete_these_links']);



                foreach ($delete_these_labels as $item) {

                    $item_id = Sanitize::escape($item);
                    $this->MiniMenu->MiniMenuItem->delete($item_id);

                }

                foreach ($delete_these_links as $item) {

                    $item_id = Sanitize::escape($item);
                    $this->MiniMenu->MiniMenuItem->delete($item_id);

                }

                if ($this->MiniMenu->saveAll($this->data)) {

                    $this->Session->setFlash('Your category has been updated.');
                    $this->redirect(array('action' => 'index'));

                }

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

            if ($this->MiniMenu->delete($id)) {

                // delete related entry_category_menu_items
                $this->MiniMenu->query("delete from mini_menu_items where mini_menu_id = $id");


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

    function remove($id = null) {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            // Check for multiple delete
            if (isset($_POST) && $_POST) {

                $warnings = '';

                foreach ($this->data['MiniMenu'] as $key => $value) {
                    if ($value == 1) {

                        $delete_this = preg_replace("/MiniMenu|delete/", "", $key);

                        if ($this->MiniMenu->delete($delete_this, false)) {

                            // delete any related MiniMenuItems, too
                            $delete_this = Sanitize::escape($delete_this);
                            $this->MiniMenu->query("delete from mini_menu_items where mini_menu_id = $delete_this");

                        } else {
                            $warnings .= 'Sorry, an mini menu couldn\'t be deleted.' . "\n";
                        }

                    } else {
                        // do not delete
                    }

                }

                if ($warnings != '')
                    $this->Session->setFlash($warnings);
                else
                    $this->Session->setflash('Selected mini menus deleted.');

                $this->redirect(array('action' => 'index'));

            } else {

                $id = Sanitize::clean($id);

                if ($this->MiniMenu->delete($id)) {

                    $this->Session->setFlash('Your mini menu has been deleted.');
                    $this->redirect(array('action' => 'index'));
                }

            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }


}

?>
