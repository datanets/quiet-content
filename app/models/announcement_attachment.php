<?php
class AnnouncementAttachment extends AppModel
{
    var $name = 'AnnouncementAttachment';
    var $displayField = 'name';
    var $belongsTo = array(
        'Announcement' => array(
            'className' => 'Announcement',
            'foreignKey' => 'announcement_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}
?>
