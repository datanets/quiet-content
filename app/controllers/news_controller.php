<?php

App::import('Sanitize');

class NewsController extends AppController {

	var $name = 'News';
    var $layout = 'admin';
    var $components = array('RequestHandler');
    var $helpers = array('Cache');
    var $cacheAction = array(
        'view' => '1 day',
        'archive' => '1 day'
    );


    function beforeFilter() {
        $this->disableCache();
        parent::beforeFilter();
    }

    function index() {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $this->set('title_for_layout', 'News');
            $this->News->contain();
            $this->set('news', $this->News->find('all', array('order' => 'News.modified DESC')));

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function create() {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $this->set('title_for_layout', 'News : New');

            $this->set('news_categories', $this->News->NewsCategory->generatetreelist('parent_id > 0', null, null, '-'));
            $this->set('statuses', $this->News->Status->list_all());
            $this->set('alignment_types', array('left top' => 'left top', 'left center' => 'left center', 'left bottom' => 'left bottom', 'right top' => 'right top', 'right center' => 'right center', 'right bottom' => 'right bottom', 'center top' => 'center top', 'center center' => 'center center', 'center bottom' => 'center bottom'));

            $this->set('dummy_item_add_image', $this->dummy_item_image());
            $this->set('dummy_item_add_attachment', $this->dummy_item_attachment());

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function edit($id = null) {

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $this->set('title_for_layout', 'News : Edit');
            $site_base_url = Configure::read('site_base_url');
            $site_preferences = $this->News->query('select * from preferences where id=1');
            $syndicate_output_file = Configure::read('syndicate_news_dir');


            $this->News->id = $id;
            $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
            $this->set('enclosures_base_url', Configure::read('enclosures_base_url'));
            $this->set('news_images_base_url', Configure::read('news_images_base_url'));
            $this->set('news_attachments_base_url', Configure::read('news_attachments_base_url'));

            $this->set('dummy_item_add_image', $this->dummy_item_image());
            $this->set('dummy_item_add_attachment', $this->dummy_item_attachment());

            $this->set('news_categories', $this->News->NewsCategory->generatetreelist('parent_id > 0', null, null, '-'));

            $this->set('statuses', $this->News->Status->list_all());
            $this->set('alignment_types', array('left top' => 'left top', 'left center' => 'left center', 'left bottom' => 'left bottom', 'right top' => 'right top', 'right center' => 'right center', 'right bottom' => 'right bottom', 'center top' => 'center top', 'center center' => 'center center', 'center bottom' => 'center bottom'));

            $splash_images_base_dir = Configure::read('splash_images_base_dir');
            $enclosures_base_dir = Configure::read('enclosures_base_dir');
            $news_images_base_dir = Configure::read('news_images_base_dir');
            $news_attachments_base_dir = Configure::read('news_attachments_base_dir');

            $resize_image_width = Configure::read('resize_image_width');
            $resize_image_height = Configure::read('resize_image_height');


            if (empty($this->data)) {

                $this->data = $this->News->read();

            } else {


                $delete_these_images = array();
                $delete_these_attachments = array();

                if (isset($_POST['delete_these_images']) && $_POST['delete_these_images'] > '')
                    $delete_these_images = split(',', $_POST['delete_these_images']);

                if (isset($_POST['delete_these_attachments']) && $_POST['delete_these_attachments'] > '')
                    $delete_these_attachments = split(',', $_POST['delete_these_attachments']);


                // Check for News Images to delete
                if (count($delete_these_images) > 0) {
                    foreach($delete_these_images as $k => $v) {

                        // get file info for when we delete from directory
                        $file_info = $this->News->NewsImage->find('first', array('fields' => 'NewsImage.name', 'conditions' => array('NewsImage.id' => $v)));

                        // delete from directory
                        unlink($news_images_base_dir . $file_info['NewsImage']['name']);

                        // delete from database
                        $this->News->NewsImage->delete($v);

                    }
                }


                // Check for News Attachments to delete
                if (count($delete_these_attachments) > 0) {
                    foreach($delete_these_attachments as $k => $v) {

                        // get file info for when we delete from directory
                        $file_info = $this->News->NewsAttachment->find('first', array('fields' => 'NewsAttachment.name', 'conditions' => array('NewsAttachment.id' => $v)));

                        // delete from directory
                        unlink($news_attachments_base_dir . $file_info['NewsAttachment']['name']);

                        // delete from database
                        $this->News->NewsAttachment->delete($v);

                    }
                }


                // Check for News Images to upload

                if (isset($this->data['NewsImage']) && count($this->data['NewsImage']) > 0) {
                    foreach ($this->data['NewsImage'] as $k => $v) :

                        if ( isset($v['name']['tmp_name']) ) {
                            if ( isset($v['name']['name']) && $v['name']['name'] > '') {

                                // is this an image? (superficial check)
                                if (eregi('(.jpeg|.jpg|.gif|.png)', $v['name']['name'])) {

                                    if (move_uploaded_file($v['name']['tmp_name'], $news_images_base_dir . $v['name']['name'])) {
                                        $this->News->resize_image($news_images_base_dir . $v['name']['name'], $resize_image_width, $resize_image_height);

                                        chmod($news_images_base_dir . $v['name']['name'] , 0777);

                                        // fix name for $this->data saving...
                                        $this->data['NewsImage'][$k]['name'] = $v['name']['name'];
                                        
                                    }

                                }

                            } else {
                                unset($this->data['NewsImage'][$k]);
                            }
                        }

                    endforeach;
                }



                // Check for News Attachments to upload

                if (isset($this->data['NewsAttachment']) && count($this->data['NewsAttachment']) > 0) {
                    foreach ($this->data['NewsAttachment'] as $k => $v) :

                        if ( isset($v['name']['tmp_name']) ) {
                            if ( isset($v['name']['name']) && $v['name']['name'] > '') {

                                if (move_uploaded_file($v['name']['tmp_name'], $news_attachments_base_dir . $v['name']['name'])) {
                                    //$this->News->resize_image($news_attachments_base_dir . $v['name']['name'], $resize_image_width, $resize_image_height);

                                    chmod($news_attachments_base_dir . $v['name']['name'] , 0777);

                                    // fix name for $this->data saving...
                                    $this->data['NewsAttachment'][$k]['name'] = $v['name']['name'];
                                    
                                }

                            } else {
                                unset($this->data['NewsAttachment'][$k]);
                            }
                        }

                    endforeach;
                }



                // Check for splash image to upload
                if (isset($_FILES['data']['name']['News']['splash_image']) && $_FILES['data']['name']['News']['splash_image'] > '') {

                    // upload file here
                    if (eregi('(.jpeg|.jpg|.gif|.png)', $_FILES['data']['name']['News']['splash_image'])) {

                        // If file is uploaded
                        if (move_uploaded_file($_FILES['data']['tmp_name']['News']['splash_image'], $splash_images_base_dir . $_FILES['data']['name']['News']['splash_image'])) {

                            $this->News->resize_image($splash_images_base_dir . $_FILES['data']['name']['News']['splash_image'], $resize_image_width, $resize_image_height);

                            chmod($splash_images_base_dir . $_FILES['data']['name']['News']['splash_image'] , 0777);

                        }
                    }


                    $this->data['News']['splash_image'] = $this->data['News']['splash_image']['name'];
                    unset($this->data['News']['existing_splash_image']);

                    $this->data['News']['no_splash_image'] = 0;    # make sure this is switched off

                } else if (isset($this->data['News']['existing_splash_image']) && $this->data['News']['existing_splash_image'] > '') {

                    $this->data['News']['splash_image'] = $this->data['News']['existing_splash_image'];
                    unset($this->data['News']['existing_splash_image']);

                } else {

                    unset($this->data['News']['splash_image']);

                }


                if (isset($this->data['News']['no_splash_image']) && $this->data['News']['no_splash_image']) {
                    $this->data['News']['splash_image'] = '';
                }



                // Check for podcast to upload
                if (isset($_FILES['data']['name']['News']['enclosure']) && $_FILES['data']['name']['News']['enclosure'] > '') {

                    // If file is uploaded
                    if (move_uploaded_file($_FILES['data']['tmp_name']['News']['enclosure'], $enclosures_base_dir . $_FILES['data']['name']['News']['enclosure'])) {

                        //$this->News->resize_image($enclosures_base_dir . $_FILES['data']['name']['News']['enclosure'], $resize_image_width, $resize_image_height);

                        chmod($enclosures_base_dir . $_FILES['data']['name']['News']['enclosure'] , 0777);

                    }

                    $this->data['News']['enclosure'] = $this->data['News']['enclosure']['name'];
                    unset($this->data['News']['existing_enclosure']);

                    $this->data['News']['no_enclosure'] = 0;    # make sure this is switched off

                } else if (isset($this->data['News']['existing_enclosure']) && $this->data['News']['existing_enclosure'] > '') {

                    $this->data['News']['enclosure'] = $this->data['News']['existing_enclosure'];
                    unset($this->data['News']['existing_enclosure']);

                } else {

                    unset($this->data['News']['enclosure']);

                }


                if (isset($this->data['News']['no_enclosure']) && $this->data['News']['no_enclosure']) {
                    $this->data['News']['enclosure'] = '';
                }


                // clear featured news setting for all previous articles if this currently-being-saved news is featured
                if (isset($this->data['News']['featured_news']) && $this->data['News']['featured_news'])
                    $this->News->query("update news set featured_news='0'");


                if ($this->News->saveAll($this->data)) {

                    // generate rss file
                    App::import('Vendor', 'RssMaker', array('file' => 'rssmaker'.DS.'rssmaker.php'));
                    $rss = new RssMaker;

                    $items = $this->News->find('all', array('order' => 'News.modified DESC', 'limit' => '10', 'conditions' => array('status_id' => '1')));

                    $rss_data = array();
                    $rss_data['title'] = $site_preferences[0]['preferences']['website_name'];
                    $rss_data['subtitle'] = 'News';
                    $rss_data['description'] = $site_preferences[0]['preferences']['website_name'];
                    $rss_data['heading_link'] = $site_base_url;
                    $rss_data['link'] = $site_base_url . 'news/';
                    $rss_data['managingEditor'] = $site_preferences[0]['preferences']['webmaster_email'];


                    for ($i = 0; $i < count($items); $i++) {

                        $rss_data['data'][$i] = $items[$i]['News'];

                    }


                    $rss->generate($rss_data, $syndicate_output_file);


                    $this->Session->setFlash('Your news has been updated.');
                    $this->redirect(array('action' => 'index'));
                }
            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }
    }

    function view($id = null) {

        $this->layout = 'public';

        $id = Sanitize::escape($id);

        $website_preferences = $this->Preference->find('first');
        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : News');
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('news_images_base_url', Configure::read('news_images_base_url'));
        $this->set('news_attachments_base_url', Configure::read('news_attachments_base_url'));


        #$this->News->contain();
        $this->set('side_nav_categories', $this->News->NewsCategory->list_side_nav_categories());

        $news = $this->News->find('first', array('conditions' => array('News.id' => $id, 'News.status_id' => '1')));
        $this->set('news', $news);

        $parent_item = $this->News->NewsCategory->getpath($news['News']['news_category_id']);

        // This is for letting the view know what categories to leave open in side nav
        $parents_path_string = '';

        if (count($parent_item) > 0) {

            foreach ($parent_item as $parent) {
                if ($parent['NewsCategory']['lft'] != 1)
                    $parents_path_string .= $parent['NewsCategory']['id'] . ',';
            }
            $parents_path_string = substr($parents_path_string, 0, -1);

        }

        $this->set('parents_path', $parents_path_string);

        // also get current category id
        $this->set('current_id', str_replace('news/', '', $this->params['url']['url']));


        $categories = $this->News->NewsCategory->find('threaded', array( 'conditions' => array(
                                                                        'NewsCategory.lft >=' => $parent_item[1]['NewsCategory']['lft'],
                                                                        'NewsCategory.rght <=' => $parent_item[1]['NewsCategory']['rght'] ),
                                                                         'order' => 'NewsCategory.lft' ));

        $this->set('categories', $categories);


        $users_array = $this->News->User->find('all', array('fields' => array('id', 'username', 'first_name', 'email')));
        $users = array();
        for ($i = 0; $i < count($users_array); $i++) {
            $users[$users_array[$i]['User']['id']] = array( 'username' => $users_array[$i]['User']['username'],
                                                            'first_name' => $users_array[$i]['User']['first_name'],
                                                            'email' => $users_array[$i]['User']['email'] );
        }

        $this->set('users', $users);

    }


    function remove($id = null) {

        $this->autoRender = false;

        // Check Permissions
        $user = $this->Session->read('Auth.User');

        if ($user['usertype'] <= 2) {

            $site_base_url = Configure::read('site_base_url');
            $site_preferences = $this->News->query('select * from preferences where id=1');
            $syndicate_output_file = Configure::read('syndicate_news_dir');


            // Check for multiple delete
            if (isset($_POST) && $_POST) {

                $warnings = '';

                foreach ($this->data['News'] as $key => $value) {
                    if ($value == 1) {

                        $delete_this = preg_replace("/News|delete/", "", $key);

                        if ($this->News->delete($delete_this, false)) {

                        } else {
                            $warnings .= 'Sorry, an news couldn\'t be deleted.' . "\n";
                        }

                    } else {
                        // do not delete
                    }

                }

                if ($warnings != '')
                    $this->Session->setFlash($warnings);
                else
                    $this->Session->setflash('Selected news deleted.');


                // generate rss file
                App::import('Vendor', 'RssMaker', array('file' => 'rssmaker'.DS.'rssmaker.php'));
                $rss = new RssMaker;

                $items = $this->News->find('all', array('order' => 'News.modified DESC', 'limit' => '10'));

                $rss_data = array();
                $rss_data['title'] = $site_preferences[0]['preferences']['website_name'];
                $rss_data['subtitle'] = 'News';
                $rss_data['description'] = $site_preferences[0]['preferences']['website_name'];
                $rss_data['link'] = $site_base_url;
                $rss_data['managingEditor'] = $site_preferences[0]['preferences']['webmaster_email'];


                for ($i = 0; $i < count($items); $i++) {

                    $rss_data['data'][$i] = $items[$i]['News'];

                }


                $rss->generate($rss_data, $syndicate_output_file);


                $this->redirect(array('action' => 'index'));

            } else {

                $id = Sanitize::clean($id);

                if ($this->News->delete($id)) {

                    $this->Session->setFlash('Your news has been deleted.');
                    $this->redirect(array('action' => 'index'));
                }
         
            }

        } else {

            $this->Session->setFlash('Sorry, permission denied.');
            $this->redirect('/home/indoors');

        }

    }

    function download($file = null) {

        $this->autoRender = false;

        $site_base_url = Configure::read('site_base_url');
        $site_base_dir = Configure::read('site_base_dir');
        $news_attachments_base_url = Configure::read('news_attachments_base_url');
        $news_attachments_base_dir = Configure::read('news_attachments_base_dir');

        $file = Sanitize::escape($_GET['file']);
        $just_the_file = str_replace($news_attachments_base_url, '', $file);


        // check if this file exists
        if (is_file($news_attachments_base_dir . $just_the_file)) {

            $file_array = preg_split('/\//', $file);

            header('Content-Disposition: attachment; file="' . end($file_array) . '"');
            readfile($file);

        } else {

            header('Location:' . $_SERVER['HTTP_REFERER'] . '#attachments');

        }

    }

    function feed() {

        $this->layout = 'default';

        if( $this->RequestHandler->isRss() ){

            $this->News->contain();
            $this->set('posts', $this->News->find('all', array( 'order' => 'News.modified DESC',
                                                                'limit' => 10,
                                                                'conditions' => array('News.status_id' => '1'))));
        }

    }

    function archive($year = null) {

        $this->layout = 'public';

        $year = Sanitize::escape($year);
        if ($year == '')
            $year = date("Y");

        $website_preferences = $this->Preference->find('first');
        $this->set('title_for_layout', $website_preferences['Preference']['website_name'] . ' : News');
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));


        $news = $this->News->find('all', array('conditions' => array('News.created between ? and ?' => array($year . '-01-01', $year . '-12-31'), 'News.status_id' => '1'), 'order' => 'News.created DESC'));
        $this->set('news', $news);


        $this->News->contain();
        $oldest_news_item = $this->News->find('first', array('conditions' => array('News.status_id' => '1'), 'order' => 'News.created'));
        $newest_news_item = $this->News->find('first', array('conditions' => array('News.status_id' => '1'), 'order' => 'News.created DESC'));


        $oldest_news_array = split(' ', $oldest_news_item['News']['created']);
        $oldest_news_array = split('-', $oldest_news_array[0]);
        $oldest_news_year = $oldest_news_array[0];

        $newest_news_array = split(' ', $newest_news_item['News']['created']);
        $newest_news_array = split('-', $newest_news_array[0]);
        $newest_news_year = $newest_news_array[0];

        if (!$oldest_news_year)
            $oldest_news_year = $newest_news_year;

        $archive_years_array = array();

        $h = 0;
        for ($i = $newest_news_year; $i > $oldest_news_year - 1; $i--) {
        //for ($i = $oldest_news_year; $i < $newest_news_year + 1; $i++) {

            $archive_years_array[$h] = $i;
            $h++;
            
        }

        $this->set('archive_years_array', $archive_years_array);

    }



    # Dummies
    function dummy_item_image() {

        $o = '<li class="ui-state-default record" id="img_0">'
            .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_image temporary temporary_0" onclick="return false;">Delete</a></div>'
            .'<input type="file" name="data[NewsImage][0][name]" value="" id="NewsImage0Name" />'
            .'<input type="hidden" name="data[NewsImage][0][news_id]" value="' . $this->News->id . '" id="NewsImage0NewsId" />'
            .'<div class="weight_box"><input type="hidden" name="data[NewsImage][0][weight]" value="1" id="NewsImage0Weight" /></div>'
            .'</li>';

        return $o;
    }

    function dummy_item_attachment() {

        $o = '<li class="ui-state-default record" id="atm_0">'
            .'<div style="float:right;"><a href="' . $this->webroot . $this->params['url']['url'] . '#" class="delete_attachment temporary temporary_0" onclick="return false;">Delete</a></div>'
            .'<input type="file" name="data[NewsAttachment][0][name]" value="" id="NewsAttachment0Name" />'
            .'<input type="hidden" name="data[NewsAttachment][0][news_id]" value="' . $this->News->id . '" id="NewsAttachment0NewsId" />'
            .'<div class="weight_box"><input type="hidden" name="data[NewsAttachment][0][weight]" value="1" id="NewsAttachment0Weight" /></div>'
            .'</li>';

        return $o;
    }



}

?>
