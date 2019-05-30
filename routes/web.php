<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontEndController@index');
Route::get('/post/{id}/{cId?}', 'FrontEndController@getPost');
Route::get('/register', 'FrontEndController@getRegister');
Route::post('/register/reg', 'UserController@register');
Route::post('/register/login', 'UserController@login');
Route::get('/about', 'FrontEndController@about');
Route::get('/gallery', 'AdminController@getGallery');
Route::get('/ajax/show', 'FrontEndController@showAnketa');
Route::post('/glasovi/insert', 'AnketaController@storeVote');
Route::get('/logout', 'UserController@logout')->name('logout');
Route::get('/download','FrontEndController@download');


Route::group(['middleware' => 'user'], function()
{
    Route::get('/user', 'FrontEndController@user');
    Route::get('/user/show/{id}', 'FrontEndController@showUser');
    Route::post('/user/update/{id}', 'UserController@updateUser');
    Route::post('/user/insert', 'PostController@insertPost');
    Route::get('/user/delete/{id}', 'PostController@deletePost');
    Route::post('/post/{id}/comment', 'CommentController@insertComment');
    Route::get('/post/{id}/delete/{cId}', 'CommentController@deleteComment');
    Route::post('/post/{id}/{cId}', 'CommentController@updateComment');
});

Route::group(['middleware' => 'admin'], function()
{
    Route::get('/admin', 'AdminController@getUsers')->name('admin_users');
    Route::get('/admin/post', 'AdminController@getPosts')->name('admin_posts');
    Route::get('/admin/navigation', 'AdminController@getNavigations')->name('admin_nav');
    Route::get('/admin/role', 'AdminController@getRoles')->name('admin_role');
    Route::get('/admin/poll', 'AdminController@getPoll')->name('admin_poll');
    
    Route::get('/admin/show/insert/user', 'AdminController@showFormUser');
    Route::post('/admin/user/insert', 'UserController@insertUser');
    Route::get('/admin/show/insert/post', 'AdminController@showFormPost');
    Route::post('/admin/post/insert', 'PostController@insertAdminPost');
    Route::get('/admin/show/insert/navigation', 'AdminController@showFormNav');
    Route::post('/admin/nav/insert', 'NavigationController@insertNav');
    Route::get('/admin/show/insert/role', 'AdminController@showFormRole');
    Route::post('/admin/role/insert', 'RoleController@insertRole');
    Route::get('/admin/show/insert/poll', 'AdminController@showFormPoll');
    Route::post('/admin/poll/insert', 'AnketaController@insertPoll');
    
    Route::get('/admin/show/update/user/{id}', 'AdminController@showUserForm');
    Route::post('/admin/user/update/{id}', 'UserController@update');  
    Route::get('/admin/show/update/post/{id}', 'AdminController@showPostForm');
    Route::post('/admin/post/update/{id}', 'PostController@updatePost');
    Route::get('/admin/show/update/nav/{id}', 'AdminController@showNavForm');
    Route::post('/admin/nav/update/{id}', 'NavigationController@updateNav');
    Route::get('/admin/show/update/role/{id}', 'AdminController@showRoleForm');
    Route::post('/admin/role/update/{id}', 'RoleController@updateRole');
    Route::get('/admin/show/update/poll/{id}', 'AdminController@showPollForm');
    Route::post('/admin/poll/update/{id}', 'AnketaController@update');
    
    Route::get('/admin/user/{id}', 'UserController@delete');
    Route::get('/admin/post/{id}', 'PostController@delete');
    Route::get('/admin/nav/{id}', 'NavigationController@delete');
    Route::get('/admin/role/{id}', 'RoleController@delete');
    Route::get('/admin/poll/{id}', 'AnketaController@delete');
    
    Route::get('/admin/poll/active/{id}', 'AnketaController@active');
});