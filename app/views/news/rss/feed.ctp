<?php


    App::import('Sanitize');
    $website_name = $website_preferences['Preference']['website_name'];
    $website_name = Sanitize::clean($website_name);


    $this->set('documentData', array(
        'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

    $this->set('channelData', array(
        'title' => __("$website_name: Latest News", true),
        'link' => $html->url('/', true),
        'description' => __("$website_name: Latest News", true),
        'language' => 'en-us'));


    foreach ($posts as $post) {
        $postTime = strtotime($post['News']['created']);
 
        $postLink = array(
            'controller' => 'entries',
            'action' => 'view',
            'year' => date('Y', $postTime),
            'month' => date('m', $postTime),
            'day' => date('d', $postTime),
            $post['News']['subject']);
        // You should import Sanitize
        App::import('Sanitize');
        // This is the part where we clean the body text for output as the description 
        // of the rss item, this needs to have only text to make sure the feed validates
        $bodyText = preg_replace('=\(.*?\)=is', '', $post['News']['entry']);
        $bodyText = $text->stripLinks($bodyText);
        $bodyText = Sanitize::stripAll($bodyText);
        $bodyText = $text->truncate($bodyText, 400, '...', true, true);
 

        echo  $rss->item(array(), array(
            'title' => $post['News']['subject'],
            'link' => $postLink,
            'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
            'description' =>  $bodyText,
            //'dc:creator' => $post['News']['author_modified'],
            'pubDate' => $post['News']['created']));
    }

?>
