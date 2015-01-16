<?php
App::import('Sanitize');

class WidgetsController extends AppController
{

    var $name = 'Widgets';

    var $layout = 'admin';

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
            $this->Widget->contain();
            $this->set('widgets', $this->Widget->find('all', array(
                'order' => 'id'
            )));
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function create()
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');
        
        if ($user['usertype'] <= 2) {
            $dummy_item_add_label = '<li class="menu_label" style="background-color:#aaa;">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_label temporary temporary_0" onclick="return false;">Delete</a></div>' . '<div style="padding:10px;padding-top:0;">' . '<label>Label</label>' . '<input type="text" id="WidgetItem0Title" name="data[WidgetItem][0][title]" value="" />' . '<input type="hidden" id="WidgetItem0ItemType" name="data[WidgetItem][0][item_type]" value="1" />' . '<div class="weight_box">' . '<input type="hidden" id="WidgetItem0Weight" name="data[WidgetItem][0][weight]" value="1" />' . '</div>' . '</div>' . '</li>';
            
            $dummy_item_add_link = '<li class="menu_label">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#delete_item" class="delete_link temporary temporary_0" onclick="return false;">Delete</a></div>' . '<div style="padding:10px;padding-top:0;">' . '<input type="hidden" id="WidgetItem0ItemType" name="data[WidgetItem][0][item_type]" value="2" />' . '<div class="weight_box">' . '<input type="hidden" id="WidgetItem0Weight" name="data[WidgetItem][0][weight]" value="1" />' . '</div>' . '<div class="category_menu_other_link_box" style="display:block;">' . '<label>Link Text</label><input type="text" id="WidgetItem0OtherLinkText" name="data[WidgetItem][0][other_link_text]" value="" style="width:300px;" />' . '<label>Link Address</label><input type="text" id="WidgetItem0OtherLink" name="data[WidgetItem][0][other_link]" value="" style="width:300px;" />' . '</div>' . '</div>' . '</li>';
            
            $this->set('dummy_item_add_label', $dummy_item_add_label);
            $this->set('dummy_item_add_link', $dummy_item_add_link);
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
            $this->Widget->id = $id;
            
            if (empty($this->data)) {
                $this->data = $this->Widget->find('first', array(
                    'contain' => '',
                    'conditions' => array(
                        'Widget.id' => $id
                    )
                ));
            } else {
                if ($this->Widget->saveAll($this->data)) {
                    $this->Session->setFlash('Widget changes have been saved.');
                    $this->redirect('/preferences/widgets');
                }
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
            
            if ($this->Widget->delete($id)) {
                // delete related entry_category_menu_items
                $this->Widget->query("delete from widget_items where widget_id = $id");
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

    function remove($id = null)
    {
        $this->autoRender = false;
        
        // Check Permissions
        $user = $this->Session->read('Auth.User');
        
        if ($user['usertype'] <= 2) {
            // Check for multiple delete
            if (isset($_POST) && $_POST) {
                $warnings = '';
                foreach ($this->data['Widget'] as $key => $value) {
                    if ($value == 1) {
                        $delete_this = preg_replace("/Widget|delete/", "", $key);
                        $delete_this = Sanitize::escape($delete_this);
                        
                        if ($this->Widget->delete($delete_this, false)) {
                            // delete any related WidgetItems, too
                        } else {
                            $warnings .= 'Sorry, a widget couldn\'t be deleted.' . "\n";
                        }
                    } else {
                        // do not delete
                    }
                }
                
                if ($warnings != '')
                    $this->Session->setFlash($warnings);
                else
                    $this->Session->setflash('Selected widgets deleted.');
                
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $id = Sanitize::clean($id);
                
                if ($this->Widget->delete($id)) {
                    $this->Session->setFlash('Your widget has been deleted.');
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
}
?>
