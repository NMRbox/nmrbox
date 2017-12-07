<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
if ($this->app->isLocal()) {
    Route::get('/_debugbar/assets/stylesheets', [
        'as' => 'debugbar-css',
        'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
    ]);

    Route::get('/_debugbar/assets/javascript', [
        'as' => 'debugbar-js',
        'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
    ]);
}

/**
 * Model binding into route
 */
Route::model('blogcategory', 'App\BlogCategory');
Route::model('blog', 'App\Blog');
Route::pattern('slug', '[a-z0-9- _]+');

/*Route::group(array('prefix' => 'admin'), function() {
    //All basic routes defined here
    Route::get('login', array('as' => 'admin-login','uses' => 'AuthController@getLogin'));
    Route::post('login','AuthController@postLogin');
    Route::get('register', array('as' => 'admin-register','uses' => 'AuthController@getRegister'));
    Route::post('register','AuthController@postRegister');
    Route::get('logout', array('as' => 'logout','uses' => 'AuthController@getLogout'));
});*/


/* Software Registry*/
Route::model('software', 'App\Software');
Route::group(array('prefix' => 'registry'), function() {
    //All basic routes defined here
    Route::get('/', array('as' => 'registry','uses' => 'RegistryController@index'));
    Route::get('{software}', array('as' => 'software-page','uses' => 'RegistryController@getSoftware'));
    Route::get('software-metadata/{software}', array('as' => 'software-metadata','uses' => 'RegistryController@getSoftwareMetaData'));
    Route::post('software-search', array('as' => 'software-search','uses' => 'RegistryController@postRegistrySearch'));
    Route::get('filter-software-search/{software}', array('as' => 'filter-software-search','uses' => 'RegistryController@filterSoftwares'));
});

/* Keywords management */
Route::model('keyword', 'App\Kewword');
Route::group(array('prefix' => 'tags'), function() {
    //All basic routes defined here
    Route::get('/', array('as' => 'tags','uses' => 'KeywordController@index'));
    Route::get('all-tags', array('as' => 'all-tags','uses' => 'KeywordController@getAllKeywords'));
    Route::post('all-tags', array('as' => 'all-tags','uses' => 'KeywordController@getAllKeywords'));
});

/* Categories management */
Route::model('category', 'App\Category');
Route::group(array('prefix' => 'cats'), function() {
    //All basic routes defined here
    Route::get('/', array('as' => 'cats','uses' => 'CategoryController@index'));
    Route::get('all-cats', array('as' => 'all-cats','uses' => 'CategoryController@getAllCategories'));
    Route::post('all-cats', array('as' => 'all-cats','uses' => 'CategoryController@getAllCategories'));
});

/* VM management */
Route::model('VM', 'App\VM');
Route::group(array('prefix' => 'vms'), function() {
    //All basic routes defined here
    Route::get('/', array('as' => 'vms','uses' => 'VMController@index'));
    Route::get('all-vms', array('as' => 'all-vms','uses' => 'VMController@getAllVMs'));
    Route::post('all-vms', array('as' => 'all-vms','uses' => 'VMController@getAllVMs'));
});

// All files public for now, unless requirements change
Route::model('file', 'App\File');
Route::group(array('prefix' => 'files'), function() {
    Route::post('store', array('as' => 'file.store', 'uses' => 'FileController@storeFiles'));
    Route::post('save', array('as' => 'file.save', 'uses' => 'FileController@uploadAndGetURL'));
    Route::get('{file}/delete', array('as' => 'file.deletefile', 'uses' => 'FileController@deleteFile'));
    Route::get('{file}/download', array('as' => 'file.downloadfile', 'uses' => 'FileController@downloadFile'));
    Route::get('{file}', array('as' => 'file.get', 'uses' => 'FileController@getFile'));
});

// protected routes
Route::group(array('prefix' => 'admin', 'middleware' => 'SentinelAdmin'), function () {
    //Route::get('/{username}', array('as' => 'dashboard','uses' => 'ChandraController@showHome'));
    Route::get('/', array('as' => 'dashboard','uses' => 'ChandraController@showHome'));

    /*# User Management
    Route::group(array('prefix' => 'users'), function () {
        Route::get('/', array('as' => 'users', 'uses' => 'UsersController@getIndex'));
        Route::get('create',array('as' => 'users.create', 'uses' => 'UsersController@getCreate'));
        Route::post('create', 'UsersController@postCreate');
        Route::get('{userId}/edit', array('as' => 'users.edit', 'uses' => 'UsersController@getEdit'));
        Route::post('{userId}/edit', 'UsersController@postEdit');
        Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'UsersController@getDelete'));
        Route::get('{userId}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete'));
        Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'UsersController@getRestore'));
    });*/

    /*# Group Management
    Route::group(array('prefix' => 'groups'), function () {
        Route::get('/', array('as' => 'groups', 'uses' => 'GroupsController@getIndex'));
        Route::get('create', array('as' => 'create/group', 'uses' => 'GroupsController@getCreate'));
        Route::post('create', 'GroupsController@postCreate');
        Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'GroupsController@getEdit'));
        Route::post('{groupId}/edit', 'GroupsController@postEdit');
        Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'GroupsController@getDelete'));
        Route::get('{groupId}/confirm-delete', array('as' => 'confirm-delete/group', 'uses' => 'GroupsController@getModalDelete'));
        Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'GroupsController@getRestore'));
    });*/

    /*routes for blog
    Route::group(array('prefix' => 'blog','before' => 'Sentinel'), function () {
        Route::get('/', array('as' => 'blogs', 'uses' => 'BlogController@getIndex'));
        Route::get('create', array('as' => 'create/blog', 'uses' => 'BlogController@getCreate'));
        Route::post('create', 'BlogController@postCreate');
        Route::get('{blog}/edit', array('as' => 'update/blog', 'uses' => 'BlogController@getEdit'));
        Route::post('{blog}/edit', 'BlogController@postEdit');
        Route::get('{blog}/delete', array('as' => 'delete/blog', 'uses' => 'BlogController@getDelete'));
        Route::get('{blog}/confirm-delete', array('as' => 'confirm-delete/blog', 'uses' => 'BlogController@getModalDelete'));
        Route::get('{blog}/restore', array('as' => 'restore/blog', 'uses' => 'BlogController@getRestore'));
        Route::get('{blog}/show', array('as' => 'blog/show', 'uses' => 'BlogController@show'));
        Route::post('{blog}/storecomment', array('as' => 'restore/blog', 'uses' => 'BlogController@storecomment'));
    });*/

    /*routes for blog category*/
    Route::group(array('prefix' => 'blogcategory','before' => 'Sentinel'), function () {
        Route::get('/', array('as' => 'blogcategories', 'uses' => 'BlogCategoryController@getIndex'));
        Route::get('create', array('as' => 'create/blogcategory', 'uses' => 'BlogCategoryController@getCreate'));
        Route::post('create', 'BlogCategoryController@postCreate');
        Route::get('{blogcategory}/edit', array('as' => 'update/blogcategory', 'uses' => 'BlogCategoryController@getEdit'));
        Route::post('{blogcategory}/edit', 'BlogCategoryController@postEdit');
        Route::get('{blogcategory}/delete', array('as' => 'delete/blogcategory', 'uses' => 'BlogCategoryController@getDelete'));
        Route::get('{blogcategory}/confirm-delete', array('as' => 'confirm-delete/blogcategory', 'uses' => 'BlogCategoryController@getModalDelete'));
        Route::get('{blogcategory}/restore', array('as' => 'restore/blogcategory', 'uses' => 'BlogCategoryController@getRestore'));
    });

    # Software Management
    Route::model('software_version', 'App\SoftwareVersion');
    Route::model('vm', 'App\VM');
    Route::model('citation', 'App\Citation');
    Route::group(array('prefix' => 'software'), function () {
        // Basic CRUD
        Route::get('/', array('as' => 'adminSoftware', 'uses' => 'SoftwareController@index'));
        Route::get('create', array('as' => 'software.create', 'uses' => 'SoftwareController@create'));
        Route::post('create', array('as' => 'software.store', 'uses' => 'SoftwareController@store'));
        Route::get('{software}/edit', array('as' => 'software.edit', 'uses' => 'SoftwareController@edit'));
        Route::put('{software}/edit', array('as' => 'software.update', 'uses' => 'SoftwareController@update'));
        Route::get('{software}/delete', array('as' => 'delete/software', 'uses' => 'SoftwareController@destroy'));

        // Tabs within software page
        Route::get('{software}/edit/people', array('as' => 'software.edit-developer', 'uses' => 'SoftwareController@edit'));
        Route::get('{software}/edit/legal', array('as' => 'software.edit-legal', 'uses' => 'SoftwareController@edit'));
        Route::get('{software}/edit/versions', array('as' => 'software.edit-versions', 'uses' => 'SoftwareController@edit'));
        Route::get('{software}/edit/citations', array('as' => 'software.edit-citations', 'uses' => 'SoftwareController@edit'));
        Route::get('{software}/edit/keywords', array('as' => 'software.edit-keywords', 'uses' => 'SoftwareController@edit'));
        Route::get('{software}/edit/files', array('as' => 'software.edit-files', 'uses' => 'SoftwareController@edit'));

        // Legal
        Route::put('{software}/edit/legal', array('as' => 'software.updatelegal', 'uses' => 'SoftwareController@updateLegal'));

        // People
        Route::get('{software}/edit/people/existing/{person}/remove', array('as' => 'software.detach-person', 'uses' => 'SoftwareController@detachPerson'));
        Route::post('{software}/edit/people/new/add', array('as' => 'software.add-new-person', 'uses' => 'SoftwareController@addNewPerson'));
        Route::post('{software}/edit/people/existing/add', array('as' => 'software.add-existing-person', 'uses' => 'SoftwareController@addExistingPerson'));
        Route::post('{software}/edit/people/edit', array('as' => 'software.people-edit', 'uses' => 'SoftwareController@updatePeople'));

        // Versions
        Route::post('{software}/edit/versions', array('as' => 'software.versions', 'uses' => 'SoftwareController@storeSoftwareVersion'));
        Route::post('{software}/edit/versions/vm-software', array('as' => 'software.vm-software', 'uses' => 'SoftwareController@storeSoftwareVersionPair'));
        Route::get('{software}/edit/versions/vm-software/delete/{vm}/{software_version}', array('as' => 'software.vm-software.delete', 'uses' => 'SoftwareController@destroySoftwareVersionPair'));
        Route::get('{software}/edit/versions/{software_version}/delete', array('as' => 'software.versionsdelete', 'uses' => 'SoftwareController@destroySoftwareVersion'));
        Route::get('{software}/edit/versions/{software_version}/{new_version}', array('as' => 'software.versionsedit', 'uses' => 'SoftwareController@editSoftwareVersion'));

        Route::post('{software}/edit/keywords/save', array('as' => 'software.save-keywords', 'uses' => 'SoftwareController@saveKeywords'));
        Route::put('{software}/edit/keywords/save', array('as' => 'software.save-keywords', 'uses' => 'SoftwareController@saveKeywords'));

        // Images
        Route::get('{software}/edit/images', array('as' => 'software.images', 'uses' => 'SoftwareController@edit'));
        Route::post('{software}/edit/images', array('as' => 'software.images', 'uses' => 'SoftwareController@storeFiles'));

        // Files
        Route::get('{software}/file/{file}/delete', array('as' => 'software.deletefile', 'uses' => 'SoftwareController@deleteFile'));
        Route::post('{software}/edit/files', array('as' => 'software.files', 'uses' => 'SoftwareController@storeFiles'));
        Route::get('{software}/file/{file}/download', array('as' => 'software.downloadfile', 'uses' => 'SoftwareController@downloadFile'));
        Route::get('{software}/file/{file}', array('as' => 'software.getfile', 'uses' => 'SoftwareController@getFile'));
    });

    # VM Management
    Route::model('vm', 'App\VM');
    Route::group(array('prefix' => 'vm'), function () {
        Route::get('/', array('as' => 'admin/vm', 'uses' => 'VMController@index'));
        Route::get('create', array('as' => 'vm.create', 'uses' => 'VMController@create'));
        Route::post('create', array('as' => 'vm.store', 'uses' => 'VMController@store'));
        Route::get('{vm}/edit', array('as' => 'vm.edit', 'uses' => 'VMController@edit'));
        Route::put('{vm}/edit', array('as' => 'vm.update', 'uses' => 'VMController@update'));
        Route::get('{vm}/delete', array('as' => 'vm.delete', 'uses' => 'VMController@destroy'));
    });

    # People Management
    Route::model('person', 'App\Person');
    Route::group(array('prefix' => 'people'), function () {
        Route::get('/', array('as' => 'admin/people', 'uses' => 'PersonController@index'));
        Route::get('create', array('as' => 'person.create', 'uses' => 'PersonController@create'));
        Route::post('create', array('as' => 'person.store', 'uses' => 'PersonController@store'));
        Route::get('{person}/edit', array('as' => 'person.edit', 'uses' => 'PersonController@edit'));
        Route::put('{person}/edit', array('as' => 'person.update', 'uses' => 'PersonController@update'));
        Route::get('{person}/delete', array('as' => 'person.delete', 'uses' => 'PersonController@destroy'));
        Route::post('get_user_details', array('as' => 'person.getUserDetails', 'uses' => 'PersonController@getUserDetails'));
        Route::post('send_email', array('as' => 'person.sendEmail', 'uses' => 'PersonController@sendEmail'));
        Route::post('show', array('as' => 'person.show', 'uses' => 'PersonController@show'));
        Route::post('email_template', array('as' => 'person.email_template', 'uses' => 'PersonController@email_template'));
        Route::post('assign_classification', array('as' => 'person.assign_classification', 'uses' => 'PersonController@assignPersonClassification'));
        Route::post('get_users_classification', array('as' => 'person.get_users_classification', 'uses' => 'PersonController@getPersonClassification'));
    });

    # Keyword Management
    Route::model('keyword', 'App\Keyword');
    Route::group(array('prefix' => 'keyword'), function () {
        Route::get('/', array('as' => 'admin/keyword', 'uses' => 'KeywordController@index'));
        Route::get('create', array('as' => 'keyword.create', 'uses' => 'KeywordController@create'));
        Route::post('create', array('as' => 'keyword.store', 'uses' => 'KeywordController@store'));
        Route::get('{keyword}/edit', array('as' => 'keyword.edit', 'uses' => 'KeywordController@edit'));
        Route::put('{keyword}/edit', array('as' => 'keyword.update', 'uses' => 'KeywordController@update'));
        Route::get('{keyword}/delete', array('as' => 'keyword.delete', 'uses' => 'KeywordController@destroy'));
    });

    # Category Management
    Route::model('category', 'App\Category');
    Route::group(array('prefix' => 'categories'), function () {
        Route::get('/', array('as' => 'admin/keyword', 'uses' => 'CategoryController@index'));
        Route::get('create', array('as' => 'category.create', 'uses' => 'CategoryController@create'));
        Route::post('create', array('as' => 'category.store', 'uses' => 'CategoryController@store'));
        Route::get('{category}/edit', array('as' => 'category.edit', 'uses' => 'CategoryController@edit'));
        Route::put('{category}/edit', array('as' => 'category.update', 'uses' => 'CategoryController@update'));
        Route::get('{category}/delete', array('as' => 'category.delete', 'uses' => 'CategoryController@destroy'));
        Route::get('all-cats', array('as' => 'all-cats','uses' => 'CategoryController@getAllCategories'));
        Route::post('all-cats', array('as' => 'all-cats','uses' => 'CategoryController@getAllCategories'));
    });

    # Lab Role Management
    Route::model('lab_role', 'App\LabRole');
    Route::group(array('prefix' => 'lab_roles'), function () {
        Route::get('/', array('as' => 'admin/lab_roles', 'uses' => 'LabRoleController@index'));
        Route::get('create', array('as' => 'lab_role.create', 'uses' => 'LabRoleController@create'));
        Route::post('create', array('as' => 'lab_role.store', 'uses' => 'LabRoleController@store'));
        Route::get('{lab_role}/edit', array('as' => 'lab_role.edit', 'uses' => 'LabRoleController@edit'));
        Route::put('{lab_role}/edit', array('as' => 'lab_role.update', 'uses' => 'LabRoleController@update'));
        Route::get('{lab_role}/delete', array('as' => 'lab_role.delete', 'uses' => 'LabRoleController@destroy'));
    });

    Route::model('page', 'App\Page');
    /*routes for page*/
    Route::group(array('prefix' => 'pages','before' => 'Sentinel'), function () {
        Route::get('/', array('as' => 'pages', 'uses' => 'PageController@getIndex'));
        Route::get('create', array('as' => 'create/page', 'uses' => 'PageController@getCreate'));
        Route::post('create', 'PageController@postCreate');
        Route::get('{page}/edit', array('as' => 'update/page', 'uses' => 'PageController@getEdit'));
        Route::post('{page}/edit', 'PageController@postEdit');
        Route::get('{page_id}/delete', array('as' => 'delete/page', 'uses' => 'PageController@getDelete'));
        Route::get('{page_id}/confirm-delete', array('as' => 'confirm-delete/page', 'uses' => 'PageController@getModalDelete'));
        Route::get('{page}/restore', array('as' => 'restore/page', 'uses' => 'PageController@getRestore'));
        Route::post('insert_files', 'PageController@insertFiles');
    });
    
    # File Management
    Route::model('file', 'App\File');
    Route::group(array('prefix' => 'files'), function () {
        Route::get('/', array('as' => 'admin/files', 'uses' => 'FileController@index'));
        Route::get('{file}', array('as' => 'file.getfile', 'uses' => 'FileController@getFile'));
        Route::get('create', array('as' => 'file.create', 'uses' => 'FileController@create'));
        Route::post('create', array('as' => 'file.store', 'uses' => 'FileController@store'));
        Route::get('{file}/edit', array('as' => 'file.edit', 'uses' => 'FileController@edit'));
        Route::post('{file}/edit', array('as' => 'file.update', 'uses' => 'FileController@update'));
        Route::get('{file}/delete', array('as' => 'file.delete', 'uses' => 'FileController@destroy'));
        Route::post('test', array('as' => 'file.test', 'uses' => 'FileController@test'));
    });

    # Search Keyword Management
    Route::model('search_keyword', 'App\SearchKeyword');
    Route::group(array('prefix' => 'search_keyword'), function () {
        Route::get('/', array('as' => 'admin/search_keyword', 'uses' => 'SearchKeywordController@index'));
        Route::get('create', array('as' => 'search_keyword.create', 'uses' => 'SearchKeywordController@create'));
        Route::post('create', array('as' => 'search_keyword.store', 'uses' => 'SearchKeywordController@store'));
        Route::get('{search_keyword}/edit', array('as' => 'search_keyword.edit', 'uses' => 'SearchKeywordController@edit'));
        Route::put('{search_keyword}/edit', array('as' => 'search_keyword.update', 'uses' => 'SearchKeywordController@update'));
        Route::get('{search_keyword}/delete', array('as' => 'search_keyword.delete', 'uses' => 'SearchKeywordController@destroy'));
    });

    # Email Management
    Route::model('email', 'App\Email');
    Route::group(array('prefix' => 'email'), function () {
        Route::get('/', array('as' => 'admin/email', 'uses' => 'EmailController@index'));
        Route::get('create', array('as' => 'email.create', 'uses' => 'EmailController@create'));
        Route::post('create', array('as' => 'email.store', 'uses' => 'EmailController@store'));
        Route::get('{email}/edit', array('as' => 'email.edit', 'uses' => 'EmailController@edit'));
        Route::put('{email}/edit', array('as' => 'email.update', 'uses' => 'EmailController@update'));
        Route::get('{email}/delete', array('as' => 'email.delete', 'uses' => 'EmailController@destroy'));
    });

    # FAQ Management
    Route::model('faq', 'App\FAQ');
    Route::group(array('prefix' => 'faq'), function () {
        Route::get('/', array('as' => 'admin/faq', 'uses' => 'FAQController@index'));
        Route::get('create', array('as' => 'faq.create', 'uses' => 'FAQController@create'));
        Route::post('create', array('as' => 'faq.store', 'uses' => 'FAQController@store'));
        Route::get('{faq}/edit', array('as' => 'faq.edit', 'uses' => 'FAQController@edit'));
        Route::post('{faq}/edit', array('as' => 'faq.update', 'uses' => 'FAQController@update'));
        Route::get('{faq}/delete', array('as' => 'faq.delete', 'uses' => 'FAQController@destroy'));
    });

    # Classifications Management
    Route::model('classification', 'App\Classification');
    Route::group(array('prefix' => 'classification'), function () {
        Route::get('/', array('as' => 'admin/classification', 'uses' => 'ClassificationController@index'));
        Route::get('create', array('as' => 'classification.create', 'uses' => 'ClassificationController@create'));
        Route::post('create', array('as' => 'classification.store', 'uses' => 'ClassificationController@store'));
        Route::get('{classification}/edit', array('as' => 'classification.edit', 'uses' => 'ClassificationController@edit'));
        Route::put('{classification}/edit', array('as' => 'classification.update', 'uses' => 'ClassificationController@update'));
        Route::get('{classification}/delete', array('as' => 'classification.delete', 'uses' => 'ClassificationController@destroy'));
    });

    # Workshop Management
    Route::model('workshop', 'App\Workshops');
    Route::group(array('prefix' => 'workshop'), function () {
        Route::get('/', array('as' => 'admin/workshop', 'uses' => 'WorkshopsController@index'));
        Route::get('create', array('as' => 'workshop.create', 'uses' => 'WorkshopsController@create'));
        Route::post('create', array('as' => 'workshop.store', 'uses' => 'WorkshopsController@store'));
        Route::get('{workshop}/edit', array('as' => 'workshop.edit', 'uses' => 'WorkshopsController@edit'));
        Route::put('{workshop}/edit', array('as' => 'workshop.update', 'uses' => 'WorkshopsController@update'));
        Route::get('{workshop}/delete', array('as' => 'workshop.delete', 'uses' => 'WorkshopsController@destroy'));
    });


    # VMDownload Management
    Route::model('vmdownload', 'App\VMDownload');
    Route::group(array('prefix' => 'vmdownload'), function () {
        Route::get('/', array('as' => 'admin/vmdownload', 'uses' => 'VMDownloadController@index'));
        Route::get('create', array('as' => 'vmdownload.create', 'uses' => 'VMDownloadController@create'));
        Route::post('create', array('as' => 'vmdownload.store', 'uses' => 'VMDownloadController@store'));
        Route::get('{vmdownload}/edit', array('as' => 'vmdownload.edit', 'uses' => 'VMDownloadController@edit'));
        Route::put('{vmdownload}/edit', array('as' => 'vmdownload.update', 'uses' => 'VMDownloadController@update'));
        Route::get('{vmdownload}/delete', array('as' => 'vmdownload.delete', 'uses' => 'VMDownloadController@destroy'));
    });

    //Remaining pages will be called from below controller method
    //in real world scenario, you may be required to define all routes manually
    Route::get('{name?}', 'ChandraController@showView');

});

#FrontEndController Group
Route::model('person', 'App\Person');
Route::group(array('prefix' => 'person'), function () {
    Route::get('{person}', array('as' => 'person', 'uses' => 'FrontEndController@person_details'));
});

# Login
Route::get('login', array('as' => 'login','uses' => 'FrontEndController@getLogin'));
Route::post('login','FrontEndController@postLogin');

# Logout
Route::get('logout', array('as' => 'logout','uses' => 'FrontEndController@getLogout'));

# Register
Route::get('register', array('as' => 'register','uses' => 'FrontEndController@getRegister'));
Route::post('register','FrontEndController@postRegister');
Route::get('register-person', array('as' => 'register-person','uses' => 'FrontEndController@getRegisterPerson'));
Route::post('register-person','FrontEndController@postRegisterPerson');
Route::get('registration-success', array('as' => 'registration-success','uses' => 'FrontEndController@getLogout'));

# Change password
Route::post('change-password', 'FrontEndController@postChangePassword');
Route::post('verify-password', 'FrontEndController@verifyLdapAuthentication');

# Forget password
Route::get('forgot-password',array('as' => 'forgot-password','uses' => 'FrontEndController@getForgotPassword'));
Route::post('forgot-password','FrontEndController@postForgotPassword');

# Forgot Password Confirmation
Route::get('forgot-password-confirm/{userId}/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'FrontEndController@getForgotPasswordConfirm'));
Route::post('forgot-password-confirm/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');

# My account display and update details
Route::get('update_profile', array('as' => 'update_profile', 'uses' => 'FrontEndController@editProfile'));
Route::put('{person}/update_profile', array('as' => 'person.update_profile', 'uses' => 'FrontEndController@updatePersonProfile'));
//Route::group(array('middleware' => 'SentinelUser'), function () {
Route::group(array(), function () {
//Route::get('my-account/{token}', array('as' => 'my-account', 'uses' => 'FrontEndController@myAccount'));
Route::get('my-account', array('as' => 'my-account', 'uses' => 'FrontEndController@myAccount'));
});

# downloadable VM form
Route::post('download_vm',array('as' => 'download_vm','uses' => 'FrontEndController@downloadVM'));

# contact form
Route::post('contact',array('as' => 'contact','uses' => 'FrontEndController@postContact'));

# Workshop Page
Route::get('workshops',array('as' => 'workshops','uses' => 'WorkshopsController@showAll'));
Route::post('workshops',array('as' => 'register_person_workshop', 'uses' => 'WorkshopsController@registerPersonWorkshop'));
Route::post('register_person_workshop', array('as' => 'register_person_workshop', 'uses' => 'WorkshopsController@registerPersonWorkshop'));

# FAQ Page
Route::get('faq',array('as' => 'faq','uses' => 'FAQController@showAllFAQs'));
Route::post('faq',array('as' => 'faq','uses' => 'FAQController@showAllFAQs'));
Route::post('faq-ratings', array('as' => 'faq-ratings', 'uses' => 'FAQController@countFAQRatings'));

# Homepage
Route::get('/', array('as' => 'home', 'uses' => 'ChandraController@showFrontEndView'));

Route::get('blog', array('as' => 'blog', 'uses' => 'BlogController@getIndexFrontend'));
Route::get('blog/{slug}/tag', 'BlogController@getBlogTagFrontend');
Route::get('blog/{slug?}', 'BlogController@getBlogFrontend');
Route::post('blog/{blog}/comment', 'BlogController@storeCommentFrontend');
Route::get('{name?}', 'ChandraController@showFrontEndView');

#Angular Frontend singin, signup and user_details
Route::group(['middleware' => ['cors', 'session']], function () {

    Route::post('signup', array( 'as' => 'signup', 'uses' => 'FrontEndController@signup'));
    Route::post('signin', array( 'as' => 'signin', 'uses' => 'FrontEndController@signin'));
    Route::post('updateProfile/{person_id}', array( 'as' => 'updateProfile', 'uses' => 'FrontEndController@updateProfile'));
    Route::post('password-reset', array( 'as' => 'password-reset', 'uses' => 'FrontEndController@changePassword'));
    Route::post('password-forgot', array( 'as' => 'password-forgot', 'uses' => 'FrontEndController@forgotPassword'));
    Route::post('password-forgot-confirm', array( 'as' => 'password-forgot-confirm', 'uses' => 'FrontEndController@confirmForgotPassword'));
    Route::post('downloadable-vm', array( 'as' => 'downloadable-vm', 'uses' => 'FrontEndController@downloadableVM'));
});

# End of frontend views

