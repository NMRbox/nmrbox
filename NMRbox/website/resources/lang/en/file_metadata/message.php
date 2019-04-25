<?php
/**
* Language file for email template error/success messages
*
*/

return array(

    'file_metadata_exists'              => 'Metadata already exists!',
    'file_metadata_not_found'           => 'Metadata [:name] does not exist.',
        
    
    'success' => array(
        'create'    => 'Metadata was successfully created.',
        'update'    => 'Metadata was successfully updated.',
        'delete'    => 'Metadata was successfully deleted.',
        'restored'  => 'Metadata was successfully restored.'
    ),

    'error' => array(
        'create'    => 'There was an issue creating the file metadata. Please try again.',
        'update'    => 'There was an issue updating the file metadata. Please try again.',
        'delete'    => 'Can not be deleted!! This metadata has reference entries in another table.',
    ),

);
