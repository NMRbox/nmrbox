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

Route::group(array('prefix' => 'admin'), function() {
    //All basic routes defined here
    Route::get('login', array('as' => 'admin-login','uses' => 'AuthController@getLogin'));
    Route::post('login','AuthController@postLogin');
    Route::get('register', array('as' => 'admin-register','uses' => 'AuthController@getRegister'));
    Route::post('register','AuthController@postRegister');
    Route::get('logout', array('as' => 'logout','uses' => 'AuthController@getLogout'));
});

Route::model('software', 'App\Software');
Route::group(array('prefix' => 'registry'), function() {
    //All basic routes defined here
    Route::get('/', array('as' => 'registry','uses' => 'RegistryController@index'));
    Route::get('{software}', array('as' => 'software-page','uses' => 'RegistryController@getSoftware'));
    Route::get('logout', array('as' => 'logout','uses' => 'AuthController@getLogout'));
});

// All files public for now, unless requirements change
Route::model('file', 'App\File');
Route::group(array('prefix' => 'files'), function() {
    Route::post('store', array('as' => 'file.store', 'uses' => 'FileController@storeFiles'));
    Route::get('{file}/delete', array('as' => 'file.deletefile', 'uses' => 'FileController@deleteFile'));
    Route::get('{file}/download', array('as' => 'file.downloadfile', 'uses' => 'FileController@downloadFile'));
    Route::get('{file}', array('as' => 'file.get', 'uses' => 'FileController@getFile'));
});

// protected routes
Route::group(array('prefix' => 'admin', 'middleware' => 'SentinelAdmin'), function () {

    Route::get('/', array('as' => 'dashboard','uses' => 'ChandraController@showHome'));

    # User Management
    Route::group(array('prefix' => 'users'), function () {
        Route::get('/', array('as' => 'users', 'uses' => 'UsersController@getIndex'));
        Route::get('create',array('as' => 'users.create', 'uses' => 'UsersController@getCreate'));
        Route::post('create', 'UsersController@postCreate');
        Route::get('{userId}/edit', array('as' => 'users.edit', 'uses' => 'UsersController@getEdit'));
        Route::post('{userId}/edit', 'UsersController@postEdit');
        Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'UsersController@getDelete'));
        Route::get('{userId}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete'));
        Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'UsersController@getRestore'));
        Route::get('{userId}', array('as' => 'users.show', 'uses' => 'UsersController@show'));
    });

    # Group Management
    Route::group(array('prefix' => 'groups'), function () {
        Route::get('/', array('as' => 'groups', 'uses' => 'GroupsController@getIndex'));
        Route::get('create', array('as' => 'create/group', 'uses' => 'GroupsController@getCreate'));
        Route::post('create', 'GroupsController@postCreate');
        Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'GroupsController@getEdit'));
        Route::post('{groupId}/edit', 'GroupsController@postEdit');
        Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'GroupsController@getDelete'));
        Route::get('{groupId}/confirm-delete', array('as' => 'confirm-delete/group', 'uses' => 'GroupsController@getModalDelete'));
        Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'GroupsController@getRestore'));
    });

    /*routes for blog*/
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
    });

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
//    Route::model('software', 'App\Software'); // already included above
    Route::model('software_version', 'App\SoftwareVersion');
    Route::model('vm', 'App\VM');
    Route::model('citation', 'App\Citation');
//    Route::model('file', 'App\File'); // already included above
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
        
        // Citations (RIP)
//        Route::get('{software}/edit/citations/{citation}/attach', array('as' => 'software.attach-citation', 'uses' => 'SoftwareController@attachCitation'));
//        Route::get('{software}/edit/citations/{citation}/delete', array('as' => 'software.detach-citation', 'uses' => 'SoftwareController@detachCitation'));
        
        // Keywords
        Route::get('{software}/edit/keywords/existing/{keyword}/remove', array('as' => 'software.detach-keyword', 'uses' => 'SoftwareController@detachKeyword'));
        Route::post('{software}/edit/keywords/new/add', array('as' => 'software.add-new-keyword', 'uses' => 'SoftwareController@addNewKeyword'));
        Route::post('{software}/edit/keywords/existing/add', array('as' => 'software.add-existing-keyword', 'uses' => 'SoftwareController@addExistingKeyword'));
        Route::post('{software}/edit/keywords/edit', array('as' => 'software.keywords-edit', 'uses' => 'SoftwareController@updatePeople'));
        
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
    });

    //Remaining pages will be called from below controller method
    //in real world scenario, you may be required to define all routes manually
    Route::get('{name?}', 'ChandraController@showView');

});

#FrontEndController

Route::get('registration-success', array('as' => 'registration-success','uses' => 'FrontEndController@getLogout'));

Route::get('login', array('as' => 'login','uses' => 'FrontEndController@getLogin'));
Route::post('login','FrontEndController@postLogin');
Route::get('register', array('as' => 'register','uses' => 'FrontEndController@getRegister'));
Route::post('register','FrontEndController@postRegister');
Route::get('register-person', array('as' => 'register-person','uses' => 'FrontEndController@getRegisterPerson'));
Route::post('register-person','FrontEndController@postRegisterPerson');
Route::get('forgot-password',array('as' => 'forgot-password','uses' => 'FrontEndController@getForgotPassword'));
Route::post('forgot-password','FrontEndController@postForgotPassword');
# Forgot Password Confirmation
Route::get('forgot-password/{userId}/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'FrontEndController@getForgotPasswordConfirm'));
Route::post('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');
# My account display and update details
Route::group(array('middleware' => 'SentinelUser'), function () {
    Route::get('my-account', array('as' => 'my-account', 'uses' => 'FrontEndController@myAccount'));
    Route::post('my-account', 'FrontEndController@updateAccount');
});
Route::get('logout', array('as' => 'logout','uses' => 'FrontEndController@getLogout'));
# contact form
Route::post('contact',array('as' => 'contact','uses' => 'FrontEndController@postContact'));

#frontend views
//Route::get('/', array('as' => 'home', function () {
//    return View::make('index');
//}));

Route::get('/', array('as' => 'home', 'uses' => 'ChandraController@showFrontEndView'));

Route::get('blog', array('as' => 'blog', 'uses' => 'BlogController@getIndexFrontend'));
Route::get('blog/{slug}/tag', 'BlogController@getBlogTagFrontend');
Route::get('blog/{slug?}', 'BlogController@getBlogFrontend');
Route::post('blog/{blog}/comment', 'BlogController@storeCommentFrontend');

Route::get('{name?}', 'ChandraController@showFrontEndView');
# End of frontend views

