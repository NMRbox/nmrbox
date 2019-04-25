<?php
/**
* Language file for email template error/success messages
*
*/

return array(

    'file_metadata_exists'              => 'Search keyword already exists!',
    'file_metadata_not_found'           => 'Keyword [:name] does not exist.',
        
    
    'success' => array(
        'create'    => 'Keyword was successfully created.',
        'update'    => 'Keyword was successfully updated.',
        'delete'    => 'Keyword was successfully deleted.',
        'restored'  => 'Keyword was successfully restored.'
    ),

    'error' => array(
        'create'    => 'There was an issue creating the search keyword. Please try again.',
        'update'    => 'There was an issue updating the search keyword. Please try again.',
        'delete'    => 'Can not be deleted!! This keyword has reference entries in another table.',
    ),

);
