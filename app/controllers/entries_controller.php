<?php
App::import('Sanitize');

class EntriesController extends AppController
{

    var $name = 'Entries';

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
            $this->set('title_for_layout', 'Entries');
            $this->Entry->contain();
            $this->set('entries', $this->Entry->find('all', array(
                'order' => 'Entry.modified DESC'
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
            $this->set('title_for_layout', 'Entries : New');
            $this->set('entry_categories', $this->EntryCategory->generatetreelist('parent_id > 0', null, null, '-'));
            $this->set('statuses', $this->Entry->Status->list_all());
            $this->set('dummy_item_add_image', $this->dummy_item_image());
            $this->set('dummy_item_add_attachment', $this->dummy_item_attachment());
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
            $splash_images_base_dir = Configure::read('splash_images_base_dir');
            $enclosures_base_dir = Configure::read('enclosures_base_dir');
            $entry_images_base_dir = Configure::read('entry_images_base_dir');
            $entry_attachments_base_dir = Configure::read('entry_attachments_base_dir');
            $resize_image_width = Configure::read('resize_image_width');
            $resize_image_height = Configure::read('resize_image_height');
            
            $this->Entry->id = $id;
            $this->set('title_for_layout', 'Entries : Edit');
            $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
            $this->set('enclosures_base_url', Configure::read('enclosures_base_url'));
            $this->set('entry_images_base_url', Configure::read('entry_images_base_url'));
            $this->set('entry_attachments_base_url', Configure::read('entry_attachments_base_url'));
            $this->set('dummy_item_add_image', $this->dummy_item_image());
            $this->set('dummy_item_add_attachment', $this->dummy_item_attachment());
            $this->set('entry_categories', $this->EntryCategory->generatetreelist('parent_id > 0', null, null, '-'));
            $this->set('statuses', $this->Entry->Status->list_all());
            
            if (empty($this->data)) {
                $this->data = $this->Entry->read();
            } else {
                $delete_these_images = array();
                $delete_these_attachments = array();
                
                if (isset($_POST['delete_these_images']) && $_POST['delete_these_images'] > '')
                    $delete_these_images = split(',', $_POST['delete_these_images']);
                
                if (isset($_POST['delete_these_attachments']) && $_POST['delete_these_attachments'] > '')
                    $delete_these_attachments = split(',', $_POST['delete_these_attachments']);
                    
                    // Check for Entry Images to delete
                if (count($delete_these_images) > 0) {
                    foreach ($delete_these_images as $k => $v) {
                        // get file info for when we delete from directory
                        $file_info = $this->Entry->EntryImage->find('first', array(
                            'fields' => 'EntryImage.name',
                            'conditions' => array(
                                'EntryImage.id' => $v
                            )
                        ));
                        
                        // delete from directory
                        unlink($entry_images_base_dir . $file_info['EntryImage']['name']);
                        
                        // delete from database
                        $this->Entry->EntryImage->delete($v);
                    }
                }
                
                // Check for Entry Attachments to delete
                if (count($delete_these_attachments) > 0) {
                    foreach ($delete_these_attachments as $k => $v) {
                        // get file info for when we delete from directory
                        $file_info = $this->Entry->EntryAttachment->find('first', array(
                            'fields' => 'EntryAttachment.name',
                            'conditions' => array(
                                'EntryAttachment.id' => $v
                            )
                        ));
                        
                        // delete from directory
                        unlink($entry_attachments_base_dir . $file_info['EntryAttachment']['name']);
                        
                        // delete from database
                        $this->Entry->EntryAttachment->delete($v);
                    }
                }
                
                // Check for Entry Images to upload
                if (isset($this->data['EntryImage']) && count($this->data['EntryImage']) > 0) {
                    foreach ($this->data['EntryImage'] as $k => $v) :
                        if (isset($v['name']['tmp_name'])) {
                            if (isset($v['name']['name']) && $v['name']['name'] > '') {
                                // is this an image? (superficial check)
                                if (eregi('(.jpeg|.jpg|.gif|.png)', $v['name']['name'])) {
                                    if (move_uploaded_file($v['name']['tmp_name'], $entry_images_base_dir . $v['name']['name'])) {
                                        $this->Entry->resize_image($entry_images_base_dir . $v['name']['name'], $resize_image_width, $resize_image_height);
                                        chmod($entry_images_base_dir . $v['name']['name'], 0777);
                                        
                                        // fix name for $this->data saving...
                                        $this->data['EntryImage'][$k]['name'] = $v['name']['name'];
                                    }
                                }
                            } else {
                                unset($this->data['EntryImage'][$k]);
                            }
                        }
                    endforeach
                    ;
                }
                
                // Check for Entry Attachments to upload
                if (isset($this->data['EntryAttachment']) && count($this->data['EntryAttachment']) > 0) {
                    foreach ($this->data['EntryAttachment'] as $k => $v) :
                        if (isset($v['name']['tmp_name'])) {
                            if (isset($v['name']['name']) && $v['name']['name'] > '') {
                                if (move_uploaded_file($v['name']['tmp_name'], $entry_attachments_base_dir . $v['name']['name'])) {
                                    chmod($entry_attachments_base_dir . $v['name']['name'], 0777);
                                    
                                    // fix name for $this->data saving...
                                    $this->data['EntryAttachment'][$k]['name'] = $v['name']['name'];
                                }
                            } else {
                                unset($this->data['EntryAttachment'][$k]);
                            }
                        }
                    endforeach
                    ;
                }
                
                // Check for splash image to upload
                if (isset($_FILES['data']['name']['Entry']['splash_image']) && $_FILES['data']['name']['Entry']['splash_image'] > '') {
                    // upload file here
                    if (eregi('(.jpeg|.jpg|.gif|.png)', $_FILES['data']['name']['Entry']['splash_image'])) {
                        // If file is uploaded
                        if (move_uploaded_file($_FILES['data']['tmp_name']['Entry']['splash_image'], $splash_images_base_dir . $_FILES['data']['name']['Entry']['splash_image'])) {
                            $this->Entry->resize_image($splash_images_base_dir . $_FILES['data']['name']['Entry']['splash_image'], $resize_image_width, $resize_image_height);
                            
                            chmod($splash_images_base_dir . $_FILES['data']['name']['Entry']['splash_image'], 0777);
                        }
                    }
                    
                    $this->data['Entry']['splash_image'] = $this->data['Entry']['splash_image']['name'];
                    unset($this->data['Entry']['existing_splash_image']);
                    
                    $this->data['Entry']['no_splash_image'] = 0; // make sure this is switched off
                } else 
                    if (isset($this->data['Entry']['existing_splash_image']) && $this->data['Entry']['existing_splash_image'] > '') {
                        $this->data['Entry']['splash_image'] = $this->data['Entry']['existing_splash_image'];
                        unset($this->data['Entry']['existing_splash_image']);
                    } else {
                        unset($this->data['Entry']['splash_image']);
                    }
                
                if (isset($this->data['Entry']['no_splash_image']) && $this->data['Entry']['no_splash_image']) {
                    $this->data['Entry']['splash_image'] = '';
                }
                
                // Check for podcast to upload
                if (isset($_FILES['data']['name']['Entry']['enclosure']) && $_FILES['data']['name']['Entry']['enclosure'] > '') {
                    // If file is uploaded
                    if (move_uploaded_file($_FILES['data']['tmp_name']['Entry']['enclosure'], $enclosures_base_dir . $_FILES['data']['name']['Entry']['enclosure'])) {
                        chmod($enclosures_base_dir . $_FILES['data']['name']['Entry']['enclosure'], 0777);
                    }
                    
                    $this->data['Entry']['enclosure'] = $this->data['Entry']['enclosure']['name'];
                    unset($this->data['Entry']['existing_enclosure']);
                    
                    $this->data['Entry']['no_enclosure'] = 0; // make sure this is switched off
                } else 
                    if (isset($this->data['Entry']['existing_enclosure']) && $this->data['Entry']['existing_enclosure'] > '') {
                        $this->data['Entry']['enclosure'] = $this->data['Entry']['existing_enclosure'];
                        unset($this->data['Entry']['existing_enclosure']);
                    } else {
                        unset($this->data['Entry']['enclosure']);
                    }
                
                if (isset($this->data['Entry']['no_enclosure']) && $this->data['Entry']['no_enclosure']) {
                    $this->data['Entry']['enclosure'] = '';
                }
                
                if ($this->Entry->saveAll($this->data)) {
                    $this->Session->setFlash('Your entry has been updated.');
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

    function view($id = null)
    {
        $this->layout = 'public';
        
        $id = Sanitize::escape($id);
        $entry = $this->Entry->find('first', array(
            'conditions' => array(
                'Entry.id' => $id,
                'Entry.status_id' => '1'
            )
        ));
        $parent_item = $this->EntryCategory->getpath($entry['Entry']['entry_category_id']);
        $website_preferences = $this->Preference->find('first');
        
        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : Entry');
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('entry_images_base_url', Configure::read('entry_images_base_url'));
        $this->set('entry_attachments_base_url', Configure::read('entry_attachments_base_url'));
        $this->set('side_nav_categories', $this->EntryCategory->list_side_nav_categories());
        $this->set('entry', $entry);
        
        // This is for letting the view know what categories to leave open in side nav
        $parents_path_string = '';
        foreach ($parent_item as $parent) {
            if ($parent['EntryCategory']['lft'] != 1)
                $parents_path_string .= $parent['EntryCategory']['id'] . ',';
        }
        $parents_path_string = substr($parents_path_string, 0, - 1);
        
        $this->set('parents_path', $parents_path_string);
        
        // also get current category id
        $this->set('current_id', str_replace('entries/', '', $this->params['url']['url']));
        
        $categories = $this->EntryCategory->find('threaded', array(
            'conditions' => array(
                'EntryCategory.lft >=' => $parent_item[1]['EntryCategory']['lft'],
                'EntryCategory.rght <=' => $parent_item[1]['EntryCategory']['rght']
            ),
            'order' => 'EntryCategory.lft'
        ));
        
        $this->set('categories', $categories);
        
        $users_array = $this->Entry->User->find('all', array(
            'fields' => array(
                'id',
                'username',
                'first_name',
                'email'
            )
        ));
        $users = array();
        for ($i = 0; $i < count($users_array); $i ++) {
            $users[$users_array[$i]['User']['id']] = array(
                'username' => $users_array[$i]['User']['username'],
                'first_name' => $users_array[$i]['User']['first_name'],
                'email' => $users_array[$i]['User']['email']
            );
        }
        
        $this->set('users', $users);
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
                foreach ($this->data['Entry'] as $key => $value) {
                    if ($value == 1) {
                        $delete_this = preg_replace("/Entry|delete/", "", $key);
                        if ($this->Entry->delete($delete_this, false)) {
                            // pass
                        } else {
                            $warnings .= 'Sorry, an event couldn\'t be deleted.' . "\n";
                        }
                    } else {
                        // do not delete
                    }
                }
                
                if ($warnings != '')
                    $this->Session->setFlash($warnings);
                else
                    $this->Session->setflash('Selected events deleted.');
                
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $id = Sanitize::clean($id);
                if ($this->Entry->delete($id)) {
                    $this->Session->setFlash('Your entry has been deleted.');
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

    function download($file = null)
    {
        $this->autoRender = false;
        
        $site_base_url = Configure::read('site_base_url');
        $site_base_dir = Configure::read('site_base_dir');
        $entry_attachments_base_url = Configure::read('entry_attachments_base_url');
        $entry_attachments_base_dir = Configure::read('entry_attachments_base_dir');
        $file = Sanitize::escape($_GET['file']);
        $just_the_file = str_replace($entry_attachments_base_url, '', $file);
        
        // check if this file exists
        if (is_file($entry_attachments_base_dir . $just_the_file)) {
            $file_array = preg_split('/\//', $file);
            
            header('Content-Disposition: attachment; file="' . end($file_array) . '"');
            readfile($file);
        } else {
            header('Location:' . $_SERVER['HTTP_REFERER'] . '#attachments');
        }
    }
    
    // Dummies
    function dummy_item_image()
    {
        $o = '<li class="ui-state-default record" id="img_0">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_image temporary temporary_0" onclick="return false;">Delete</a></div>' . '<input type="file" name="data[EntryImage][0][name]" value="" id="EntryImage0Name" /' . '<input type="hidden" name="data[EntryImage][0][entry_id]" value="' . $this->Entry->id . '" id="EntryImage0EntryId" /' . '<div class="weight_box"><input type="hidden" name="data[EntryImage][0][weight]" value="1" id="EntryImage0Weight" /></div>' . '</li>';
        
        return $o;
    }

    function dummy_item_attachment()
    {
        $o = '<li class="ui-state-default record" id="atm_0">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_attachment temporary temporary_0" onclick="return false;">Delete</a></div>' . '<input type="file" name="data[EntryAttachment][0][name]" value="" id="EntryAttachment0Name" /' . '<input type="hidden" name="data[EntryAttachment][0][entry_id]" value="' . $this->Entry->id . '" id="EntryAttachment0EntryId" /' . '<div class="weight_box"><input type="hidden" name="data[EntryAttachment][0][weight]" value="1" id="EntryAttachment0Weight" /></div>' . '</li>';
        
        return $o;
    }
}
?>
