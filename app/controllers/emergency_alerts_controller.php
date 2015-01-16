<?php
App::import('Sanitize');

class EmergencyAlertsController extends AppController
{

    var $name = 'EmergencyAlerts';

    var $layout = 'admin';

    var $components = array(
        'RequestHandler'
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
        
        if ($user['usertype'] <= 1) {
            $this->set('title_for_layout', 'Emergency Alerts');
            $this->EmergencyAlert->contain();
            $this->set('emergency_alerts', $this->EmergencyAlert->find('all', array(
                'order' => 'EmergencyAlert.modified DESC'
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
        
        if ($user['usertype'] <= 1) {
            $this->set('title_for_layout', 'Emergency Alerts : New');
            $this->set('statuses', $this->EmergencyAlert->Status->list_all());
        } else {
            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');
        }
    }

    function edit($id = null)
    {
        // Check Permissions
        $user = $this->Session->read('Auth.User');
        
        if ($user['usertype'] <= 1) {
            $site_base_url = Configure::read('site_base_url');
            $site_preferences = $this->EmergencyAlert->query('select * from preferences where id=1');
            $syndicate_output_file = Configure::read('syndicate_emergency_alerts_dir');
            $splash_images_base_dir = Configure::read('splash_images_base_dir');
            
            $this->set('title_for_layout', 'Emergency Alerts : Edit');
            $this->EmergencyAlert->id = $id;
            $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
            $this->set('statuses', $this->EmergencyAlert->Status->list_all());
            
            if (empty($this->data)) {
                $this->data = $this->EmergencyAlert->read();
            } else {
                if ($this->EmergencyAlert->saveAll($this->data)) {
                    // generate rss file
                    App::import('Vendor', 'RssMaker', array(
                        'file' => 'rssmaker' . DS . 'rssmaker.php'
                    ));
                    $rss = new RssMaker();
                    $items = $this->EmergencyAlert->find('all', array(
                        'order' => 'EmergencyAlert.modified DESC',
                        'limit' => '10',
                        'conditions' => array(
                            'status_id' => '1'
                        )
                    ));
                    $rss_data = array();
                    $rss_data['title'] = $site_preferences[0]['preferences']['website_name'];
                    $rss_data['subtitle'] = 'EmergencyAlert';
                    $rss_data['description'] = $site_preferences[0]['preferences']['website_name'];
                    $rss_data['heading_link'] = $site_base_url;
                    $rss_data['link'] = $site_base_url . 'emergency_alerts/';
                    $rss_data['managingEditor'] = $site_preferences[0]['preferences']['webmaster_email'];
                    
                    for ($i = 0; $i < count($items); $i ++) {
                        $rss_data['data'][$i] = $items[$i]['EmergencyAlert'];
                    }
                    
                    $rss->generate($rss_data, $syndicate_output_file);
                    
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
        $entry = $this->EmergencyAlert->find('first', array(
            'conditions' => array(
                'EmergencyAlert.id' => $id,
                'EmergencyAlert.status_id' => '1'
            )
        ));
        $parent_item = $this->EmergencyAlertCategory->getpath($entry['EmergencyAlert']['entry_category_id']);
        
        $this->set('title_for_layout', Configure::read('site_title'));
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('entry_images_base_url', Configure::read('entry_images_base_url'));
        $this->set('entry_attachments_base_url', Configure::read('entry_attachments_base_url'));
        $this->set('side_nav_categories', $this->EmergencyAlertCategory->list_side_nav_categories());
        $this->set('entry', $entry);
        
        // This is for letting the view know what categories to leave open in side nav
        $parents_path_string = '';
        foreach ($parent_item as $parent) {
            if ($parent['EmergencyAlertCategory']['lft'] != 1)
                $parents_path_string .= $parent['EmergencyAlertCategory']['id'] . ',';
        }
        $parents_path_string = substr($parents_path_string, 0, - 1);
        
        $this->set('parents_path', $parents_path_string);
        
        // also get current category id
        $this->set('current_id', str_replace('emergency_alerts/', '', $this->params['url']['url']));
        
        $categories = $this->EmergencyAlertCategory->find('threaded', array(
            'conditions' => array(
                'EmergencyAlertCategory.lft >=' => $parent_item[1]['EmergencyAlertCategory']['lft'],
                'EmergencyAlertCategory.rght <=' => $parent_item[1]['EmergencyAlertCategory']['rght']
            )
        ));
        
        $this->set('categories', $categories);
        
        $users_array = $this->EmergencyAlert->User->find('all', array(
            'fields' => array(
                'id',
                'username',
                'first_name',
                'email'
            )
        ));
        $users = array();
        for ($i = 0; $i < count($users_array) - 1; $i ++) {
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
        
        if ($user['usertype'] <= 1) {
            $site_base_url = Configure::read('site_base_url');
            $site_preferences = $this->EmergencyAlert->query('select * from preferences where id=1');
            $syndicate_output_file = Configure::read('syndicate_emergency_alerts_dir');
            
            // Check for multiple delete
            if (isset($_POST) && $_POST) {
                $warnings = '';
                foreach ($this->data['EmergencyAlert'] as $key => $value) {
                    if ($value == 1) {
                        $delete_this = preg_replace("/EmergencyAlert|delete/", "", $key);
                        
                        if ($this->EmergencyAlert->delete($delete_this, false)) {
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
                    
                    // generate rss file
                App::import('Vendor', 'RssMaker', array(
                    'file' => 'rssmaker' . DS . 'rssmaker.php'
                ));
                
                $rss = new RssMaker();
                $items = $this->EmergencyAlert->find('all', array(
                    'order' => 'EmergencyAlert.modified DESC',
                    'limit' => '10'
                ));
                $rss_data = array();
                $rss_data['title'] = $site_preferences[0]['preferences']['website_name'];
                $rss_data['subtitle'] = 'EmergencyAlert';
                $rss_data['description'] = $site_preferences[0]['preferences']['website_name'];
                $rss_data['link'] = $site_base_url;
                $rss_data['managingEditor'] = $site_preferences[0]['preferences']['webmaster_email'];
                
                for ($i = 0; $i < count($items); $i ++) {
                    $rss_data['data'][$i] = $items[$i]['EmergencyAlert'];
                }
                
                $rss->generate($rss_data, $syndicate_output_file);
                
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $id = Sanitize::clean($id);
                
                if ($this->EmergencyAlert->delete($id)) {
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

    function feed()
    {
        $this->layout = 'default';
        
        if ($this->RequestHandler->isRss()) {
            $this->EmergencyAlert->contain();
            $this->set('posts', $this->EmergencyAlert->find('all', array(
                'order' => 'EmergencyAlert.modified DESC',
                'limit' => 10,
                'conditions' => array(
                    'EmergencyAlert.status_id' => '1'
                )
            )));
        }
    }
    
    // This is used to get rss feeds (for emergency events) from external websites.
    function feed_proxy()
    {
        $this->autoRender = false;
        $this->loadModel('Preference');
        
        $website_preferences = $this->Preference->find('first');
        $emergency_alerts_link = $website_preferences['Preference']['emergency_alerts_link'];
        
        header('Content-type: application/xml');
        $url = $emergency_alerts_link;
        $handle = fopen($url, "r");
        
        if ($handle) {
            while (! feof($handle)) {
                $buffer = fgets($handle, 4096);
                echo $buffer;
            }
            fclose($handle);
        }
    }
    
    // Dummies
    function dummy_item_image()
    {
        $o = '<li class="ui-state-default record" id="img_0">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_image temporary temporary_0" onclick="return false;">Delete</a></div>' . '<input type="file" name="data[EmergencyAlertImage][0][name]" value="" id="EmergencyAlertImage0Name" /' . '<input type="hidden" name="data[EmergencyAlertImage][0][entry_id]" value="' . $this->EmergencyAlert->id . '" id="EmergencyAlertImage0EmergencyAlertId" /' . '<div class="weight_box"><input type="hidden" name="data[EmergencyAlertImage][0][weight]" value="1" id="EmergencyAlertImage0Weight" /></div>' . '</li>';
        
        return $o;
    }

    function dummy_item_attachment()
    {
        $o = '<li class="ui-state-default record" id="atm_0">' . '<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_attachment temporary temporary_0" onclick="return false;">Delete</a></div>' . '<input type="file" name="data[EmergencyAlertAttachment][0][name]" value="" id="EmergencyAlertAttachment0Name" /' . '<input type="hidden" name="data[EmergencyAlertAttachment][0][entry_id]" value="' . $this->EmergencyAlert->id . '" id="EmergencyAlertAttachment0EmergencyAlertId" /' . '<div class="weight_box"><input type="hidden" name="data[EmergencyAlertAttachment][0][weight]" value="1" id="EmergencyAlertAttachment0Weight" /></div>' . '</li>';
        
        return $o;
    }
}
?>
