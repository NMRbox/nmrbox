<?php
/**
* Language file for email template error/success messages
*
*/

return array(

    'success' => array(
        'create'            => 'Software successfully created.',
        'update'            => 'Software successfully updated.',
        'update_keyword'    => 'Software successfully updated.',
        'delete'            => 'Software successfully deleted.',
        'ban'               => 'Software successfully banned.',
        'unban'             => 'Software successfully unbanned.',
        'suspend'           => 'Software successfully suspended.',
        'unsuspend'         => 'Software successfully unsuspended.',
        'restored'          => 'Software successfully restored.'
    ),

    'error' => array(
        'create'    => 'There was an issue adding the software entry. Please try again.',
        'update'    => 'There was an issue updating the software entry. Please try again.',
        'delete'    => 'Can not be deleted!! This software registry has reference entries in other table.',
    ),

);
