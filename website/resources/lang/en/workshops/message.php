<?php
/**
* Language file for email Workshop error/success messages
*
*/

return array(

    'Workshop_exists'              => 'Workshop already exists!',
    'Workshop_not_found'           => 'Workshop [:name] does not exist.',
        
    
    'success' => array(
        'create'    => 'Workshop was successfully created.',
        'update'    => 'Workshop was successfully updated.',
        'delete'    => 'Workshop was successfully deleted.',
        'ban'       => 'Workshop was successfully banned.',
        'unban'     => 'Workshop was successfully unbanned.',
        'suspend'   => 'Workshop was successfully suspended.',
        'unsuspend' => 'Workshop was successfully unsuspended.',
        'restored'  => 'Workshop was successfully restored.'
    ),

    'error' => array(
        'create'    => 'There was an issue creating the Workshop. Please try again.',
        'update'    => 'There was an issue updating the Workshop. Please try again.',
        'delete'    => 'Can not be deleted!! This Workshop has reference entries in other table.',
    ),

);
