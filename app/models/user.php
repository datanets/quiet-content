<?php
class User extends AppModel
{
    var $name = 'User';
    var $hasOne = array(
        'UserType' => array(
            'foreignKey' => 'id',
            'type' => 'LEFT',
            'fields' => ' '
        )
    );
}
?>
