<?php

class TweetsController extends AppController
{

    var $name = 'Tweets';

    var $layout = 'ajax';

    function cache_feed($id)
    {
        $this->autoRender = false;
        
        $file = CACHE . 'views' . DS . 'tweet-cache-' . $id;
        
        // delete existing file
        if (file_exists($file))
            unlink($file);
            
            // get json source
        $contents = file_get_contents($_POST['source']);
        
        // save json source to file for caching
        file_put_contents($file, $contents);
    }

    function get_feed($id)
    {
        $file = CACHE . 'views' . DS . 'tweet-cache-' . $id;
        $data = 'empty';
        
        // get cached json source
        if (file_exists($file))
            $data = file_get_contents($file);
        
        $this->set('data', $data);
    }
}
?>
