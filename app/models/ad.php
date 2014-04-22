<?php
class Ad extends AppModel
{
    var $name = 'Ad';
    var $belongsTo = array(
        'AdCategory',
        'User' => array(
            'foreignKey' => 'id',
            'fields' => array('id')
        )
    );
    var $hasOne = array(
        'Status' => array(
            'foreignKey' => 'id',
            'type' => 'LEFT',
            'fields' => ' '
        )
    );
    var $actsAs = array('Containable');

    function afterSave()
    {
        if (CACHE > '') {
            // sweep away old cache files
            $dir = CACHE.'views'.DS;        
            if (!$dh = @opendir($dir)) return;
                while (false !== ($file = readdir($dh))) {
                    if ($file == '.' || $file == '..' || $file == 'empty') continue;
                    unlink ($dir.DS.$file);
                }
            closedir($dh);
        } 
    }

    function afterDelete()
    {
        if (CACHE > '') {
            // sweep away old cache files
            $dir = CACHE.'views'.DS;        
            if (!$dh = @opendir($dir)) return;
                while (false !== ($file = readdir($dh))) {
                    if ($file == '.' || $file == '..' || $file == 'empty') continue;
                    unlink ($dir.DS.$file);
                }
            closedir($dh);
        } 
    }

    function list_recent_ads($limit, $ad_type = null)
    {
        if ($ad_type) {
            return $this->find('all',
                array(
                    'conditions' => array(
                        'Ad.ad_type' => $ad_type,
                        'Ad.status_id' => '1'
                    ),
                    'order' => 'Ad.id DESC',
                    'limit' => $limit
                )
            );
        } else {
            return $this->find('all',
                array(
                    'conditions' => array('Ad.status_id' => '1'),
                    'order' => 'Ad.id DESC',
                    'limit' => $limit
                )
            );
        }
    }

    function list_featured_ads($limit, $ad_type = null)
    {
        if ($ad_type) {
            return $this->find('all',
                array(
                    'conditions' => array(
                        'Ad.ad_type' => $ad_type,
                        'Ad.status_id' => '1'
                    ),
                    'order' => 'Ad.modified DESC',
                    'limit' => $limit
                )
            );
        } else {
            return $this->find('all',
                array(
                    'conditions' => array('Ad.status_id' => '1'),
                    'order' => 'Ad.modified DESC',
                    'limit' => $limit
                )
            );
        }
    }

    function list_recent_calendar_events($limit)
    {
        return $this->find('all',
            array(
                'conditions' => 'ad_type = 1',
                'order' => 'Ad.id DESC',
                'limit' => $limit
            )
        );
    }

    function resize_image($filename, $width, $height)
    {
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

    function get_featured_ads()
    {
        return $this->find('all',
            array(
                'conditions' => array(
                    'Ad.status_id' => '1',
                    'Ad.featured_ad' => '1'
                ),
                'order' => 'Ad.modified DESC'
            )
        );
    }
}
?>
