<?php

class HomeController extends AppController {

    var $name = 'Home';
    var $layout = 'public';
    var $uses = array('Announcement', 'Entry', 'Home', 'News', 'Preference');
    var $helpers = array('Cache');
    var $cacheAction = array(
        'welcome' => '1 day'
    );


    function beforeFilter() {
        $this->disableCache();
        parent::beforeFilter();
    }

    function welcome() {

        // check for mobile devices
        if ($this->RequestHandler->isMobile() && $_GET['full'] != 'true') {
            $this->redirect('/mobile/m_welcome');
        }

        $website_preferences = $this->Preference->find('first');
        $this->set('title_for_layout', $website_preferences['Preference']['website_name']);
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));

        $this->set('splash_news', $this->News->list_featured_news(1));
        $this->set('announcements', $this->Announcement->list_featured_announcements($website_preferences['Preference']['featured_announcements_limit']));

        App::import('Vendor', 'Coreylib', array('file' => 'coreylib'.DS.'coreylib.php'));

        $website_preferences = $this->Preference->find('first');

        $website_calendar_link = '';
        if ($website_preferences['Preference']['website_calendar_link'] > '')
            $website_calendar_link = $website_preferences['Preference']['website_calendar_link'];

        $this->set('website_calendar_link', $website_calendar_link);

        // create a new instance of the coreylib clAPI class
        $api = new clAPI($website_preferences['Preference']['website_calendar']);

        // parse the feed, cache for as long as x minutes
        // for more options on specifying cache duration, see http://php.net/manual/en/function.strtotime.php
        $api->parse('1440 minutes');    // one day

        $this->set('calendar_events', $api);
        //$this->set('calendar_events', $this->Entry->list_recent_calendar_events(10));

        $this->set('featured_entries', $this->Entry->list_featured_entries(12));

    }

    function indoors() {

        $this->layout = 'admin';

        $this->set('recent_announcements', $this->Announcement->list_recent_announcements(10));
        $this->set('recent_news', $this->News->list_recent_news(10));
        $this->set('recent_entries', $this->Entry->list_recent_entries(10));

    }

}

?>
