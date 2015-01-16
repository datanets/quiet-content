<?php
App::import('Sanitize');

class AdsController extends AppController
{

    var $name = 'Ads';

    var $layout = 'admin';

    var $components = array(
        'RequestHandler'
    );

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
            $this->set('title_for_layout', 'Ads');
            $this->Ad->contain();
            $this->set('ads', $this->Ad->find('all', array(
                'order' => 'Ad.modified DESC'
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
            $this->set('title_for_layout', 'Ads : New');
            $this->set('ad_categories', $this->Ad->AdCategory->generatetreelist('parent_id > 0', null, null, '&nbsp;&nbsp;&nbsp;'));
            $this->set('statuses', $this->Ad->Status->list_all());
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
            $site_base_url = Configure::read('site_base_url');
            $site_preferences = $this->Ad->query('select * from preferences where id=1');
            $syndicate_output_file = Configure::read('syndicate_ads_dir');
            $splash_images_base_dir = Configure::read('splash_images_base_dir');
            $enclosures_base_dir = Configure::read('enclosures_base_dir');
            $ad_images_base_dir = Configure::read('ad_images_base_dir');
            $ad_attachments_base_dir = Configure::read('ad_attachments_base_dir');
            $resize_image_width = Configure::read('resize_image_width');
            $resize_image_height = Configure::read('resize_image_height');
            
            $this->set('title_for_layout', 'Ads : Edit');
            $this->Ad->id = $id;
            $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
            $this->set('enclosures_base_url', Configure::read('enclosures_base_url'));
            $this->set('ad_images_base_url', Configure::read('ad_images_base_url'));
            $this->set('ad_attachments_base_url', Configure::read('ad_attachments_base_url'));
            $this->set('dummy_item_add_image', $this->dummy_item_image());
            $this->set('dummy_item_add_attachment', $this->dummy_item_attachment());
            $this->set('ad_categories', $this->Ad->AdCategory->generatetreelist('parent_id > 0', null, null, '&nbsp;&nbsp;&nbsp;'));
            $this->set('statuses', $this->Ad->Status->list_all());
            
            if (empty($this->data)) {
                $this->data = $this->Ad->read();
            } else {
                $delete_these_images = array();
                $delete_these_attachments = array();
                
                if (isset($_POST['delete_these_images']) && $_POST['delete_these_images'] > '')
                    $delete_these_images = split(',', $_POST['delete_these_images']);
                
                if (isset($_POST['delete_these_attachments']) && $_POST['delete_these_attachments'] > '')
                    $delete_these_attachments = split(',', $_POST['delete_these_attachments']);
                    
                    // Check for Ad Images to delete
                if (count($delete_these_images) > 0) {
                    foreach ($delete_these_images as $k => $v) {
                        // get file info for when we delete from directory
                        $file_info = $this->Ad->AdImage->find('first', array(
                            'fields' => 'AdImage.name',
                            'conditions' => array(
                                'AdImage.id' => $v
                            )
                        ));
                        
                        // delete from directory
                        unlink($ad_images_base_dir . $file_info['AdImage']['name']);
                        
                        // delete from database
                        $this->Ad->AdImage->delete($v);
                    }
                }
                
                // Check for Ad Attachments to delete
                if (count($delete_these_attachments) > 0) {
                    foreach ($delete_these_attachments as $k => $v) {
                        // get file info for when we delete from directory
                        $file_info = $this->Ad->AdAttachment->find('first', array(
                            'fields' => 'AdAttachment.name',
                            'conditions' => array(
                                'AdAttachment.id' => $v
                            )
                        ));
                        
                        // delete from directory
                        unlink($ad_attachments_base_dir . $file_info['AdAttachment']['name']);
                        
                        // delete from database
                        $this->Ad->AdAttachment->delete($v);
                    }
                }
                
                // Check for Ad Images to upload
                if (isset($this->data['AdImage']) && count($this->data['AdImage']) > 0) {
                    foreach ($this->data['AdImage'] as $k => $v) :
                        if (isset($v['name']['tmp_name'])) {
                            if (isset($v['name']['name']) && $v['name']['name'] > '') {
                                // is this an image? (superficial check)
                                if (eregi('(.jpeg|.jpg|.gif|.png)', $v['name']['name'])) {
                                    
                                    if (move_uploaded_file($v['name']['tmp_name'], $ad_images_base_dir . $v['name']['name'])) {
                                        $this->Ad->resize_image($ad_images_base_dir . $v['name']['name'], $resize_image_width, $resize_image_height);
                                        
                                        chmod($ad_images_base_dir . $v['name']['name'], 0777);
                                        
                                        // fix name for $this->data saving...
                                        $this->data['AdImage'][$k]['name'] = $v['name']['name'];
                                    }
                                }
                            } else {
                                unset($this->data['AdImage'][$k]);
                            }
                        }
                    endforeach
                    ;
                }
                
                // Check for Ad Attachments to upload
                if (isset($this->data['AdAttachment']) && count($this->data['AdAttachment']) > 0) {
                    foreach ($this->data['AdAttachment'] as $k => $v) :
                        if (isset($v['name']['tmp_name'])) {
                            if (isset($v['name']['name']) && $v['name']['name'] > '') {
                                if (move_uploaded_file($v['name']['tmp_name'], $ad_attachments_base_dir . $v['name']['name'])) {
                                    chmod($ad_attachments_base_dir . $v['name']['name'], 0777);
                                    
                                    // fix name for $this->data saving...
                                    $this->data['AdAttachment'][$k]['name'] = $v['name']['name'];
                                }
                            } else {
                                unset($this->data['AdAttachment'][$k]);
                            }
                        }
                    endforeach
                    ;
                }
                
                // Check for splash image to upload
                if (isset($_FILES['data']['name']['Ad']['splash_image']) && $_FILES['data']['name']['Ad']['splash_image'] > '') {
                    // upload file here
                    if (eregi('(.jpeg|.jpg|.gif|.png)', $_FILES['data']['name']['Ad']['splash_image'])) {
                        // If file is uploaded
                        if (move_uploaded_file($_FILES['data']['tmp_name']['Ad']['splash_image'], $splash_images_base_dir . $_FILES['data']['name']['Ad']['splash_image'])) {
                            $this->Ad->resize_image($splash_images_base_dir . $_FILES['data']['name']['Ad']['splash_image'], $resize_image_width, $resize_image_height);
                            chmod($splash_images_base_dir . $_FILES['data']['name']['Ad']['splash_image'], 0777);
                        }
                    }
                    
                    $this->data['Ad']['splash_image'] = $this->data['Ad']['splash_image']['name'];
                    unset($this->data['Ad']['existing_splash_image']);
                    
                    $this->data['Ad']['no_splash_image'] = 0; // make sure this is switched off
                } else 
                    if (isset($this->data['Ad']['existing_splash_image']) && $this->data['Ad']['existing_splash_image'] > '') {
                        $this->data['Ad']['splash_image'] = $this->data['Ad']['existing_splash_image'];
                        unset($this->data['Ad']['existing_splash_image']);
                    } else {
                        unset($this->data['Ad']['splash_image']);
                    }
                
                if (isset($this->data['Ad']['no_splash_image']) && $this->data['Ad']['no_splash_image']) {
                    $this->data['Ad']['splash_image'] = '';
                }
                
                // Check for podcast to upload
                if (isset($_FILES['data']['name']['Ad']['enclosure']) && $_FILES['data']['name']['Ad']['enclosure'] > '') {
                    // If file is uploaded
                    if (move_uploaded_file($_FILES['data']['tmp_name']['Ad']['enclosure'], $enclosures_base_dir . $_FILES['data']['name']['Ad']['enclosure'])) {
                        chmod($enclosures_base_dir . $_FILES['data']['name']['Ad']['enclosure'], 0777);
                    }
                    
                    $this->data['Ad']['enclosure'] = $this->data['Ad']['enclosure']['name'];
                    unset($this->data['Ad']['existing_enclosure']);
                    
                    $this->data['Ad']['no_enclosure'] = 0; // make sure this is switched off
                } else 
                    if (isset($this->data['Ad']['existing_enclosure']) && $this->data['Ad']['existing_enclosure'] > '') {
                        $this->data['Ad']['enclosure'] = $this->data['Ad']['existing_enclosure'];
                        unset($this->data['Ad']['existing_enclosure']);
                    } else {
                        unset($this->data['Ad']['enclosure']);
                    }
                
                if (isset($this->data['Ad']['no_enclosure']) && $this->data['Ad']['no_enclosure']) {
                    $this->data['Ad']['enclosure'] = '';
                }
                
                if ($this->Ad->saveAll($this->data)) {
                    $this->Session->setFlash('Your ad has been updated.');
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
        $ad = $this->Ad->find('first', array(
            'conditions' => array(
                'Ad.id' => $id,
                'Ad.status_id' => '1'
            )
        ));
        $parent_item = $this->Ad->AdCategory->getpath($ad['Ad']['ad_category_id']);
        $website_preferences = $this->Preference->find('first');
        
        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : Ad');
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('ad_images_base_url', Configure::read('ad_images_base_url'));
        $this->set('ad_attachments_base_url', Configure::read('ad_attachments_base_url'));
        $this->set('side_nav_categories', $this->Ad->AdCategory->list_side_nav_categories());
        $this->set('ad', $ad);
        
        // This is for letting the view know what categories to leave open in side nav
        $parents_path_string = '';
        if (count($parent_item) > 0) {
            foreach ($parent_item as $parent) {
                if ($parent['AdCategory']['lft'] != 1)
                    $parents_path_string .= $parent['AdCategory']['id'] . ',';
            }
            $parents_path_string = substr($parents_path_string, 0, - 1);
        }
        
        $this->set('parents_path', $parents_path_string);
        
        // also get current category id
        $this->set('current_id', str_replace('ads/', '', $this->params['url']['url']));
        
        $categories = $this->Ad->AdCategory->find('threaded', array(
            'conditions' => array(
                'AdCategory.lft >=' => $parent_item[1]['AdCategory']['lft'],
                'AdCategory.rght <=' => $parent_item[1]['AdCategory']['rght']
            ),
            'order' => 'AdCategory.lft'
        ));
        
        $this->set('categories', $categories);
        
        $users_array = $this->Ad->User->find('all', array(
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
            
            $site_base_url = Configure::read('site_base_url');
            $site_preferences = $this->Ad->query('select * from preferences where id=1');
            $syndicate_output_file = Configure::read('syndicate_ads_dir');
            
            // Check for multiple delete
            if (isset($_POST) && $_POST) {
                $warnings = '';
                foreach ($this->data['Ad'] as $key => $value) {
                    if ($value == 1) {
                        $delete_this = preg_replace("/Ad|delete/", "", $key);
                        
                        if ($this->Ad->delete($delete_this, false)) {
                            $this->Ad->afterDelete(); // clear cache
                        } else {
                            $warnings .= 'Sorry, an ad couldn\'t be deleted.' . "\n";
                        }
                    } else {
                        // do not delete
                    }
                }
                
                if ($warnings != '')
                    $this->Session->setFlash($warnings);
                else
                    $this->Session->setflash('Selected ads deleted.');
                
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $id = Sanitize::clean($id);
                if ($this->Ad->delete($id)) {
                    $this->Session->setFlash('Your ad has been deleted.');
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
        $ad_attachments_base_url = Configure::read('ad_attachments_base_url');
        $ad_attachments_base_dir = Configure::read('ad_attachments_base_dir');
        $file = Sanitize::escape($_GET['file']);
        $just_the_file = str_replace($ad_attachments_base_url, '', $file);
        
        // check if this file exists
        if (is_file($ad_attachments_base_dir . $just_the_file)) {
            $file_array = preg_split('/\//', $file);
            
            header('Content-Disposition: attachment; file="' . end($file_array) . '"');
            readfile($file);
        } else {
            header('Location:' . $_SERVER['HTTP_REFERER'] . '#attachments');
        }
    }

    function feed()
    {
        $this->layout = 'default';
        
        if ($this->RequestHandler->isRss()) {
            $this->Ad->contain();
            $this->set('posts', $this->Ad->find('all', array(
                'order' => 'Ad.modified DESC',
                'limit' => 10,
                'conditions' => array(
                    'Ad.status_id' => '1'
                )
            )));
        }
    }
    
    // Dummies
    function dummy_item_image()
    {
        $o = '<li class="ui-state-default record" id="img_0">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_image temporary temporary_0" onclick="return false;">Delete</a></div>' . '<input type="file" name="data[AdImage][0][name]" value="" id="AdImage0Name" /' . '<input type="hidden" name="data[AdImage][0][ad_id]" value="' . $this->Ad->id . '" id="AdImage0AdId" /' . '<div class="weight_box"><input type="hidden" name="data[AdImage][0][weight]" value="1" id="AdImage0Weight" /></div>' . '</li>';
        
        return $o;
    }

    function dummy_item_attachment()
    {
        $o = '<li class="ui-state-default record" id="atm_0">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_attachment temporary temporary_0" onclick="return false;">Delete</a></div>' . '<input type="file" name="data[AdAttachment][0][name]" value="" id="AdAttachment0Name" /' . '<input type="hidden" name="data[AdAttachment][0][ad_id]" value="' . $this->Ad->id . '" id="AdAttachment0AdId" /' . '<div class="weight_box"><input type="hidden" name="data[AdAttachment][0][weight]" value="1" id="AdAttachment0Weight" /></div>' . '</li>';
        
        return $o;
    }
}
?>
