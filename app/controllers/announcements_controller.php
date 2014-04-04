<?php
App::import('Sanitize');

class AnnouncementsController extends AppController
{
    var $name = 'Announcements';
    var $layout = 'admin';
    var $components = array('RequestHandler');
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
            $this->set('title_for_layout', 'Announcements');
            $this->Announcement->contain();
            $this->set('announcements', $this->Announcement->find('all', array('order' => 'Announcement.modified DESC')));
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
            $this->set('title_for_layout', 'Announcements : New');
            $this->set('announcement_categories', $this->Announcement->AnnouncementCategory->generatetreelist('parent_id > 0', null, null, '-'));
            $this->set('statuses', $this->Announcement->Status->list_all());
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
            $site_preferences = $this->Announcement->query('select * from preferences where id=1');
            $syndicate_output_file = Configure::read('syndicate_announcements_dir');
            $splash_images_base_dir = Configure::read('splash_images_base_dir');
            $enclosures_base_dir = Configure::read('enclosures_base_dir');
            $announcement_images_base_dir = Configure::read('announcement_images_base_dir');
            $announcement_attachments_base_dir = Configure::read('announcement_attachments_base_dir');
            $resize_image_width = Configure::read('resize_image_width');
            $resize_image_height = Configure::read('resize_image_height');

            $this->set('title_for_layout', 'Announcements : Edit');
            $this->Announcement->id = $id;
            $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
            $this->set('enclosures_base_url', Configure::read('enclosures_base_url'));
            $this->set('announcement_images_base_url', Configure::read('announcement_images_base_url'));
            $this->set('announcement_attachments_base_url', Configure::read('announcement_attachments_base_url'));
            $this->set('dummy_item_add_image', $this->dummy_item_image());
            $this->set('dummy_item_add_attachment', $this->dummy_item_attachment());
            $this->set('announcement_categories', $this->Announcement->AnnouncementCategory->generatetreelist('parent_id > 0', null, null, '-'));
            $this->set('statuses', $this->Announcement->Status->list_all());

            if (empty($this->data)) {
                $this->data = $this->Announcement->read();
            } else {
                $delete_these_images = array();
                $delete_these_attachments = array();

                if (isset($_POST['delete_these_images']) && $_POST['delete_these_images'] > '')
                    $delete_these_images = split(',', $_POST['delete_these_images']);

                if (isset($_POST['delete_these_attachments']) && $_POST['delete_these_attachments'] > '')
                    $delete_these_attachments = split(',', $_POST['delete_these_attachments']);

                // Check for Announcement Images to delete
                if (count($delete_these_images) > 0) {
                    foreach($delete_these_images as $k => $v) {
                        // get file info for when we delete from directory
                        $file_info = $this->Announcement->AnnouncementImage->find('first', array('fields' => 'AnnouncementImage.name', 'conditions' => array('AnnouncementImage.id' => $v)));

                        // delete from directory
                        unlink($announcement_images_base_dir . $file_info['AnnouncementImage']['name']);

                        // delete from database
                        $this->Announcement->AnnouncementImage->delete($v);
                    }
                }

                // Check for Announcement Attachments to delete
                if (count($delete_these_attachments) > 0) {
                    foreach($delete_these_attachments as $k => $v) {
                        // get file info for when we delete from directory
                        $file_info = $this->Announcement->AnnouncementAttachment->find('first', array('fields' => 'AnnouncementAttachment.name', 'conditions' => array('AnnouncementAttachment.id' => $v)));

                        // delete from directory
                        unlink($announcement_attachments_base_dir . $file_info['AnnouncementAttachment']['name']);

                        // delete from database
                        $this->Announcement->AnnouncementAttachment->delete($v);
                    }
                }

                // Check for Announcement Images to upload
                if (isset($this->data['AnnouncementImage']) && count($this->data['AnnouncementImage']) > 0) {
                    foreach ($this->data['AnnouncementImage'] as $k => $v) :
                        if ( isset($v['name']['tmp_name']) ) {
                            if ( isset($v['name']['name']) && $v['name']['name'] > '') {
                                // is this an image? (superficial check)
                                if (eregi('(.jpeg|.jpg|.gif|.png)', $v['name']['name'])) {
                                    if (move_uploaded_file($v['name']['tmp_name'], $announcement_images_base_dir . $v['name']['name'])) {
                                        $this->Announcement->resize_image($announcement_images_base_dir . $v['name']['name'], $resize_image_width, $resize_image_height);
                                        chmod($announcement_images_base_dir . $v['name']['name'] , 0777);
                                        // fix name for $this->data saving...
                                        $this->data['AnnouncementImage'][$k]['name'] = $v['name']['name'];
                                    }
                                }
                            } else {
                                unset($this->data['AnnouncementImage'][$k]);
                            }
                        }
                    endforeach;
                }

                // Check for Announcement Attachments to upload
                if (isset($this->data['AnnouncementAttachment']) && count($this->data['AnnouncementAttachment']) > 0) {
                    foreach ($this->data['AnnouncementAttachment'] as $k => $v) :
                        if ( isset($v['name']['tmp_name']) ) {
                            if ( isset($v['name']['name']) && $v['name']['name'] > '') {
                                if (move_uploaded_file($v['name']['tmp_name'], $announcement_attachments_base_dir . $v['name']['name'])) {
                                    chmod($announcement_attachments_base_dir . $v['name']['name'] , 0777);

                                    // fix name for $this->data saving...
                                    $this->data['AnnouncementAttachment'][$k]['name'] = $v['name']['name'];
                                }
                            } else {
                                unset($this->data['AnnouncementAttachment'][$k]);
                            }
                        }
                    endforeach;
                }

                // Check for splash image to upload
                if (isset($_FILES['data']['name']['Announcement']['splash_image']) && $_FILES['data']['name']['Announcement']['splash_image'] > '') {
                    // upload file here
                    if (eregi('(.jpeg|.jpg|.gif|.png)', $_FILES['data']['name']['Announcement']['splash_image'])) {
                        // If file is uploaded
                        if (move_uploaded_file($_FILES['data']['tmp_name']['Announcement']['splash_image'], $splash_images_base_dir . $_FILES['data']['name']['Announcement']['splash_image'])) {

                            $this->Announcement->resize_image($splash_images_base_dir . $_FILES['data']['name']['Announcement']['splash_image'], $resize_image_width, $resize_image_height);

                            chmod($splash_images_base_dir . $_FILES['data']['name']['Announcement']['splash_image'] , 0777);
                        }
                    }

                    $this->data['Announcement']['splash_image'] = $this->data['Announcement']['splash_image']['name'];
                    unset($this->data['Announcement']['existing_splash_image']);

                    $this->data['Announcement']['no_splash_image'] = 0;    # make sure this is switched off
                } else if (isset($this->data['Announcement']['existing_splash_image']) && $this->data['Announcement']['existing_splash_image'] > '') {
                    $this->data['Announcement']['splash_image'] = $this->data['Announcement']['existing_splash_image'];
                    unset($this->data['Announcement']['existing_splash_image']);
                } else {
                    unset($this->data['Announcement']['splash_image']);
                }

                if (isset($this->data['Announcement']['no_splash_image']) && $this->data['Announcement']['no_splash_image']) {
                    $this->data['Announcement']['splash_image'] = '';
                }

                // Check for podcast to upload
                if (isset($_FILES['data']['name']['Announcement']['enclosure']) && $_FILES['data']['name']['Announcement']['enclosure'] > '') {
                    // If file is uploaded
                    if (move_uploaded_file($_FILES['data']['tmp_name']['Announcement']['enclosure'], $enclosures_base_dir . $_FILES['data']['name']['Announcement']['enclosure'])) {
                        chmod($enclosures_base_dir . $_FILES['data']['name']['Announcement']['enclosure'] , 0777);
                    }

                    $this->data['Announcement']['enclosure'] = $this->data['Announcement']['enclosure']['name'];
                    unset($this->data['Announcement']['existing_enclosure']);

                    $this->data['Announcement']['no_enclosure'] = 0;    # make sure this is switched off
                } else if (isset($this->data['Announcement']['existing_enclosure']) && $this->data['Announcement']['existing_enclosure'] > '') {
                    $this->data['Announcement']['enclosure'] = $this->data['Announcement']['existing_enclosure'];
                    unset($this->data['Announcement']['existing_enclosure']);
                } else {
                    unset($this->data['Announcement']['enclosure']);
                }

                if (isset($this->data['Announcement']['no_enclosure']) && $this->data['Announcement']['no_enclosure']) {
                    $this->data['Announcement']['enclosure'] = '';
                }

                if ($this->Announcement->saveAll($this->data)) {
                    // generate rss file
                    App::import('Vendor', 'RssMaker', array('file' => 'rssmaker'.DS.'rssmaker.php'));
                    $rss = new RssMaker;
                    $items = $this->Announcement->find('all',
                        array(
                            'order' => 'Announcement.modified DESC',
                            'limit' => '10',
                            'conditions' => array('status_id' => '1')
                        )
                    );

                    $rss_data = array();
                    $rss_data['title'] = $site_preferences[0]['preferences']['website_name'];
                    $rss_data['subtitle'] = 'Announcements';
                    $rss_data['description'] = $site_preferences[0]['preferences']['website_name'];
                    $rss_data['heading_link'] = $site_base_url;
                    $rss_data['link'] = $site_base_url . 'announcements/';
                    $rss_data['managingEditor'] = $site_preferences[0]['preferences']['webmaster_email'];

                    for ($i = 0; $i < count($items); $i++) {
                        $rss_data['data'][$i] = $items[$i]['Announcement'];
                    }

                    $rss->generate($rss_data, $syndicate_output_file);

                    $this->Session->setFlash('Your announcement has been updated.');
                    $this->redirect(array('action' => 'index'));
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
        $announcement = $this->Announcement->find('first',
            array(
                'conditions' => array(
                    'Announcement.id' => $id,
                    'Announcement.status_id' => '1'
                )
            )
        );
        $parent_item = $this->Announcement->AnnouncementCategory->getpath($announcement['Announcement']['announcement_category_id']);
        $website_preferences = $this->Preference->find('first');

        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : Announcement');
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('announcement_images_base_url', Configure::read('announcement_images_base_url'));
        $this->set('announcement_attachments_base_url', Configure::read('announcement_attachments_base_url'));
        $this->set('side_nav_categories', $this->Announcement->AnnouncementCategory->list_side_nav_categories());
        $this->set('announcement', $announcement);

        // This is for letting the view know what categories to leave open in side nav
        $parents_path_string = '';

        if (count($parent_item) > 0) {
            foreach ($parent_item as $parent) {
                if ($parent['AnnouncementCategory']['lft'] != 1)
                    $parents_path_string .= $parent['AnnouncementCategory']['id'] . ',';
            }
            $parents_path_string = substr($parents_path_string, 0, -1);
        }

        $this->set('parents_path', $parents_path_string);

        // also get current category id
        $this->set('current_id', str_replace('announcements/', '', $this->params['url']['url']));

        $categories = $this->Announcement->AnnouncementCategory->find('threaded',
            array(
                'conditions' => array(
                    'AnnouncementCategory.lft >=' => $parent_item[1]['AnnouncementCategory']['lft'],
                    'AnnouncementCategory.rght <=' => $parent_item[1]['AnnouncementCategory']['rght']
                ),
                'order' => 'AnnouncementCategory.lft'
            )
        );

        $this->set('categories', $categories);

        $users_array = $this->Announcement->User->find('all',
            array(
                'fields' => array('id', 'username', 'first_name', 'email')
            )
        );
        $users = array();
        for ($i = 0; $i < count($users_array); $i++) {
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
            $site_preferences = $this->Announcement->query('select * from preferences where id=1');
            $syndicate_output_file = Configure::read('syndicate_announcements_dir');

            // Check for multiple delete
            if (isset($_POST) && $_POST) {
                $warnings = '';
                foreach ($this->data['Announcement'] as $key => $value) {
                    if ($value == 1) {
                        $delete_this = preg_replace("/Announcement|delete/", "", $key);

                        if ($this->Announcement->delete($delete_this, false)) {
                            // pass
                        } else {
                            $warnings .= 'Sorry, an announcement couldn\'t be deleted.' . "\n";
                        }
                    } else {
                        // do not delete
                    }
                }

                if ($warnings != '')
                    $this->Session->setFlash($warnings);
                else
                    $this->Session->setflash('Selected announcements deleted.');

                // generate rss file
                App::import('Vendor', 'RssMaker', array('file' => 'rssmaker'.DS.'rssmaker.php'));
                $rss = new RssMaker;
                $items = $this->Announcement->find('all',
                    array('order' => 'Announcement.modified DESC', 'limit' => '10')
                );
                $rss_data = array();
                $rss_data['title'] = $site_preferences[0]['preferences']['website_name'];
                $rss_data['subtitle'] = 'Announcements';
                $rss_data['description'] = $site_preferences[0]['preferences']['website_name'];
                $rss_data['link'] = $site_base_url;
                $rss_data['managingEditor'] = $site_preferences[0]['preferences']['webmaster_email'];

                for ($i = 0; $i < count($items); $i++) {
                    $rss_data['data'][$i] = $items[$i]['Announcement'];
                }

                $rss->generate($rss_data, $syndicate_output_file, 1);

                $this->redirect(array('action' => 'index'));
            } else {
                $id = Sanitize::clean($id);
                if ($this->Announcement->delete($id)) {
                    $this->Session->setFlash('Your announcement has been deleted.');
                    $this->redirect(array('action' => 'index'));
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
        $announcement_attachments_base_url = Configure::read('announcement_attachments_base_url');
        $announcement_attachments_base_dir = Configure::read('announcement_attachments_base_dir');
        $file = Sanitize::escape($_GET['file']);
        $just_the_file = str_replace($announcement_attachments_base_url, '', $file);

        // check if this file exists
        if (is_file($announcement_attachments_base_dir . $just_the_file)) {
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

        if( $this->RequestHandler->isRss() ){
            $this->Announcement->contain();
            $this->set('posts', $this->Announcement->find('all',
                array(
                    'order' => 'Announcement.modified DESC',
                    'limit' => 10,
                    'conditions' => array('Announcement.status_id' => '1')
                )
            ));
        }
    }

    // Dummies
    function dummy_item_image()
    {
        $o = '<li class="ui-state-default record" id="img_0">'
            .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_image temporary temporary_0" onclick="return false;">Delete</a></div>'
            .'<input type="file" name="data[AnnouncementImage][0][name]" value="" id="AnnouncementImage0Name" /'
            .'<input type="hidden" name="data[AnnouncementImage][0][announcement_id]" value="' . $this->Announcement->id . '" id="AnnouncementImage0AnnouncementId" /'
            .'<div class="weight_box"><input type="hidden" name="data[AnnouncementImage][0][weight]" value="1" id="AnnouncementImage0Weight" /></div>'
            .'</li>';

        return $o;
    }

    function dummy_item_attachment()
    {
        $o = '<li class="ui-state-default record" id="atm_0">'
            .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_attachment temporary temporary_0" onclick="return false;">Delete</a></div>'
            .'<input type="file" name="data[AnnouncementAttachment][0][name]" value="" id="AnnouncementAttachment0Name" /'
            .'<input type="hidden" name="data[AnnouncementAttachment][0][announcement_id]" value="' . $this->Announcement->id . '" id="AnnouncementAttachment0AnnouncementId" /'
            .'<div class="weight_box"><input type="hidden" name="data[AnnouncementAttachment][0][weight]" value="1" id="AnnouncementAttachment0Weight" /></div>'
            .'</li>';

        return $o;
    }
}
?>
