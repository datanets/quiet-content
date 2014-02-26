<?php
class AnnouncementAttachment extends AppModel {
	var $name = 'AnnouncementAttachment';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
