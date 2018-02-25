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
        'register' => 'Thank you for registering for the event. You will receive more information from NMRbox staff by email as the event date approaches.',
        'already_registered' => 'You are already registered for the events. You will receive more information from NMRbox staff by email as the event date approaches.'
    ),

    'error' => array(
        'create'    => 'There was an issue creating the Workshop. Please try again.',
        'update'    => 'There was an issue updating the Workshop. Please try again.',
        'delete'    => 'Can not be deleted!! This Workshop has reference entries in other table.',
    ),

);
