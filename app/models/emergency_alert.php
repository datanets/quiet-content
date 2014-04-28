<?php
class EmergencyAlert extends AppModel
{
    var $name = 'EmergencyAlert';
    var $belongsTo = array(
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

    function list_all($limit = null)
    {
        $this->contain();

        if ($limit) {
            return $this->find('all',
                array(
                    'order' => 'EmergencyAlert.id DESC',
                    'limit' => $limit
                )
            );
        } else {
            return $this->find('all',
                array('order' => 'EmergencyAlert.id DESC')
            );
        }
    }

    function list_featured_entries($limit)
    {
        return $this->find('all',
            array(
                'conditions' => array(
                    'featured_entry' => '1', 'status_id' => '1'
                ),
                'order' => 'EmergencyAlert.id DESC',
                'limit' => $limit,
                'fields' => 'id, subject, splash_image',
                'recursive' => '0'
            )
        );
    }
}
?>
