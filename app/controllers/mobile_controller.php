<?php
class MobileController extends AppController
{
    var $name = 'Mobile';
    var $layout = 'mobile';
    var $uses = array('Announcement', 'Entry', 'Mobile', 'News', 'Preference');
    var $helpers = array('Cache');

    function beforeFilter()
    {
        $this->disableCache();
        parent::beforeFilter();
    }

    function m_welcome()
    {
        $website_preferences = $this->Preference->find('first');
        $this->set('title_for_layout', $website_preferences['Preference']['website_name']);
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('splash_news', $this->News->list_featured_news(1));
    }

    function m_news($id = null)
    {
        $website_preferences = $this->Preference->find('first');
        $this->set('title_for_layout', $website_preferences['Preference']['website_name']);
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));

        $this->News->id = $id;
        $this->data = $this->News->read();

        $users_array = $this->News->User->find('all', array('fields' => array('id', 'username', 'first_name', 'email')));
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

    function m_staff_list($id = null)
    {
        $website_preferences = $this->Preference->find('first');
        $widgets = $website_preferences['Widget'];
        $widget_action_links = array();
        $widget_action_link_results = array();

        for ($i=0; $i<count($widgets); $i++) {
            if ($website_preferences['Widget'][$i]['action_link'] > '') {
                array_push($widget_action_links, $website_preferences['Widget'][$i]['action_link']);

                // create curl resource
                $ch = curl_init();

                // set url
                curl_setopt($ch, CURLOPT_URL, $website_preferences['Widget'][$i]['action_link']);

                //return the transfer as a string
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                // $output contains the output string
                $raw_output = curl_exec($ch);
                $widget_action_link_results[$website_preferences['Widget'][$i]['id']] = json_decode($raw_output);

                // close curl resource to free up system resources
                curl_close($ch);
            }
        }
        
        $this->set('title_for_layout', $website_preferences['Preference']['website_name']);
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('widget_action_links', $widget_action_links);
        $this->set('widget_action_link_results', $widget_action_link_results);
    }

    function m_calendar($id = null)
    {
        App::import('Vendor', 'Coreylib', array('file' => 'coreylib'.DS.'coreylib.php'));

        $website_preferences = $this->Preference->find('first');
        $website_calendar_link = '';

        if ($website_preferences['Preference']['website_calendar_link'] > '')
            $website_calendar_link = $website_preferences['Preference']['website_calendar_link'];

        // create a new instance of the coreylib clAPI class
        $api = new clAPI($website_preferences['Preference']['website_calendar']);

        // parse the feed, cache for as long as x minutes
        // for more options on specifying cache duration, see http://php.net/manual/en/function.strtotime.php
        $api->parse('1440 minutes');    // one day

        $this->set('title_for_layout', $website_preferences['Preference']['website_name']);
        $this->set('splash_images_base_url', Configure::read('splash_images_base_url'));
        $this->set('website_calendar_link', $website_calendar_link);
        $this->set('calendar_events', $api);
    }
}
?>
