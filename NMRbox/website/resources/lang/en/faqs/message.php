<?php
/**
* Language file for email template error/success messages
*
*/

return array(

    'faq_exists'              => 'FAQ already exists!',
    'faq_not_found'           => 'FAQ [:name] does not exist.',
        
    
    'success' => array(
        'create'    => 'FAQ entry was successfully created.',
        'update'    => 'FAQ entry was successfully updated.',
        'delete'    => 'FAQ entry was successfully deleted.',
    ),

    'error' => array(
        'create'    => 'There was an issue creating the faq. Please try again.',
        'update'    => 'There was an issue updating the faq. Please try again.',
        'delete'    => 'Can not be deleted!! Remove the pivot table entries in FAQ edit page and try again. ',
    ),

);
