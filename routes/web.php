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

Route::get('signup/activate/{token}', 'AuthController@signupActivate');

Auth::routes(['verify' => true]);

Route::get('users/{id}', function ($id) {

});
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', 'HomeController@courier')->name('courier');
    Route::get('/home', 'HomeController@index')->name('index');
    Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('clients', 'ClientController');
	Route::resource('jobs_type', 'JobtypeController');
	Route::resource('leads', 'LeadController');

    Route::get('/logoutOther', 'UserController@logoutOther')->name('logoutOther');
	Route::post('/logOtherDevices', 'UserController@logOtherDevices')->name('logOtherDevices');
	Route::post('permisions/{id}', 'UserController@permisions')->name('permisions');
	Route::get('getUsers', 'UserController@getUsers')->name('getUsers');
	Route::post('profile/{id}', 'UserController@profile')->name('profile');
	Route::post('getUserPro/{id}', 'UserController@getUserPro')->name('getUserPro');
	Route::post('getUserPerm/{id}', 'UserController@getUserPerm')->name('getUserPerm');
	Route::post('password', 'UserController@password')->name('password');
	Route::patch('AuthUserUp/{id}', 'UserController@AuthUserUp')->name('AuthUserUp');
	Route::post('UserShip', 'UserController@UserShip')->name('UserShip');
	Route::get('deletedUsers', 'UserController@deletedUsers')->name('deletedUsers');
	Route::patch('undeletedUser/{id}', 'UserController@undeletedUser')->name('undeletedUser');
	Route::delete('delete_user/{id}', 'UserController@delete_user')->name('delete_user');
	Route::get('filter_users/{id}', 'UserController@filter_users')->name('filter_users');


	Route::get('getUsersRole', 'RoleController@getUsersRole')->name('getUsersRole');
	Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');
	Route::get('getPermissions', 'RoleController@getPermissions')->name('getPermissions');
	Route::post('getRolesPerm/{id}', 'RoleController@getRolesPerm')->name('getRolesPerm');
    Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');

    // Reports
	Route::post('marketing', 'ReportController@marketing')->name('marketing');
	Route::post('product_report', 'ReportController@product_report')->name('product_report');

});
