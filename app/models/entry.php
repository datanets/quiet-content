<?php

class Entry extends AppModel {

	var $name = 'Entry';

    var $belongsTo = array( 'EntryCategory',
                            'User' => array('foreignKey' => 'id',
                                            'fields' => array('id')));

    var $hasOne = array('Status' => array( 'foreignKey' => 'id',
                                            'type' => 'LEFT',
                                            'fields' => ' ' ));

    var $hasMany = array('EntryImage' => array( 'foreignKey' => 'entry_id',
                                                  'type' => 'INNER',
                                                  'order' => 'EntryImage.weight' ),
                         'EntryAttachment' => array('foreignKey' => 'entry_id',
                                                  'type' => 'INNER',
                                                  'order' => 'EntryAttachment.weight',
                                                    )
                                                    );

    var $actsAs = array('Containable');


    function afterSave() {
        $homepage_cache_filename = Configure::read('homepage_cache_filename');

        // sweep away old homepage 
        if (is_file(CACHE.'views'.DS.$homepage_cache_filename))
            unlink(CACHE.'views'.DS.$homepage_cache_filename);

        // sweep away old entry category indexes as well
        if (CACHE > '') {

            $dir = CACHE.'views'.DS;
            if (!$dh = @opendir($dir)) return;
            while (false !== ($file = readdir($dh))) {
                if ($file == '.' || $file == '..' || $file == 'empty') continue;
                if (preg_match("/entries_category/i", $file))
                    unlink ($dir.DS.$file);
            }
            closedir($dh);

        }

    }

    function afterDelete() {
        $homepage_cache_filename = Configure::read('homepage_cache_filename');

        // sweep away old homepage 
        if (is_file(CACHE.'views'.DS.$homepage_cache_filename))
            unlink(CACHE.'views'.DS.$homepage_cache_filename);

        // sweep away old entry category indexes as well
        if (CACHE > '') {

            $dir = CACHE.'views'.DS;
            if (!$dh = @opendir($dir)) return;
            while (false !== ($file = readdir($dh))) {
                if ($file == '.' || $file == '..' || $file == 'empty') continue;
                if (preg_match("/entries_category/i", $file))
                    unlink ($dir.DS.$file);
            }
            closedir($dh);

        }

    }


    function list_recent_entries($limit, $entry_type = null) {
        if ($entry_type)
            return $this->find('all', array('conditions' => 'Entry.entry_type = ' . $entry_type, 'order' => 'Entry.id DESC', 'limit' => $limit));
        else
            return $this->find('all', array('order' => 'Entry.id DESC', 'limit' => $limit));
    }

    function list_featured_entries($limit) {
        return $this->find('all', array('conditions' => array('featured_entry' => '1', 'status_id' => '1'),
                                        'order' => 'Entry.id DESC',
                                        'limit' => $limit,
                                        'fields' => 'id, subject, splash_image',
                                        'recursive' => '0'));
    }

    function list_recent_calendar_events($limit) {
        return $this->find('all', array('conditions' => 'entry_type = 1', 'order' => 'Entry.id DESC', 'limit' => $limit));
    }

    function resize_image($filename, $width, $height) {

        list ($width_orig, $height_orig, $file_type) = getimagesize($filename);

        if (($width_orig > $width) || ($height_orig > $height)) {

            if ($width && ($width_orig < $height_orig)) {
                $width = ($height / $height_orig) * $width_orig;
            } else {
                $height = ($width / $width_orig) * $height_orig;
            }

            ob_start();

            if ($file_type == 1)
                $src_img = imagecreatefromgif($filename);
            else if ($file_type == 2)
                $src_img = imagecreatefromjpeg($filename);
            else if ($file_type == 3)
                $src_img = imagecreatefrompng($filename);
            else
                $src_img = imagecreatefromjpeg($filename);

            $dst_img = imagecreatetruecolor($width, $height);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

            imagejpeg($dst_img, $filename, 75);

            imagedestroy($dst_img);
            imagedestroy($src_img);

            ob_end_clean();

        }

    }

}

?>
