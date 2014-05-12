<?php
class NewsAttachment extends AppModel
{
    var $name = 'NewsAttachment';
    var $displayField = 'name';
    var $belongsTo = array(
        'News' => array(
            'className' => 'News',
            'foreignKey' => 'news_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}
?>
