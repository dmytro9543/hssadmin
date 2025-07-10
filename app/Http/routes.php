<?php
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/sysinform');
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web', 'auth']], function () {
    //
	Route::get('/sysinform', 'CommonController@index');
	Route::get('/updatePassword', 'CommonController@updatePassword');
});


Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/getRandom', 'CommonController@createRandom');
});

Route::group(['namespace' => 'imsi','middleware'=>['web', 'auth', 'adminperm']], 
	function(){
		Route::get('/pdn','PdnController@index');
		Route::get('/pdn/getinfo','PdnController@getInfo');
		Route::post('/pdn/saveinfo','PdnController@saveInfo');
		Route::post('/pdn/deletePdnInfo','PdnController@deletePdnInfo');
		
		Route::get('/profile', 'ProfileController@index');
		Route::get('/getProfileInfo', 'ProfileController@getProfileInfo');
		Route::get('/profile/getApnName', 'ProfileController@getApn');
		Route::get('/deleteProfileInfo', 'ProfileController@deleteProfileInfo');
		Route::get('/saveProfileInfo','ProfileController@saveProfileInfo');
		Route::get('/changeDefault','ProfileController@changeDefault');
				

		Route::get('/imsi','ImsiController@index');
		Route::get('/imsi/getProfileName','ImsiController@getProfileName');
		Route::get('/imsi/getProfileInfo','ImsiController@getProfileInfo');
		Route::post('/saveIMSIInfo','ImsiController@saveIMSIInfo');
		Route::get('/getRemark','ImsiController@getRemark');
		Route::get('/getIMSIInfo','ImsiController@getIMSIInfo');
		Route::get('/getKI','ImsiController@getKI');
		Route::get('/imsi/getApn','ImsiController@get_ApnName_According_To_IMSI');
		Route::get('/deleteImsiInfo','ImsiController@deleteImsiInfo');
		Route::get('/getPdnList','ImsiController@getPdnList');
		Route::get('/searchIMSI','ImsiController@searchIMSI');
		Route::post('/imsi','ImsiController@getCSVFile');
		Route::get('/getDefaultProfile','ImsiController@getDefaultProfile');
		Route::get('/imsi/isExistOpc','ImsiController@isExistOpc');
});

Route::group(['namespace' => 'imei', 'middleware'=>['web', 'auth', 'adminperm']], 
function(){
	Route::get('/blackList','ImeiController@index');
	Route::get('/imeiinfoSave','ImeiController@saveIMEIInfo');
	Route::get('/whiteList','ImeiController@index');
	Route::post('/getIMEIInfo','ImeiController@getIMEIInfo');
	Route::post('/getRemark','ImeiController@getRemark');
	Route::post('/deleteIMEIInfo','ImeiController@deleteIMEIInfo');
});

Route::group(['namespace' => 'security', 'middleware'=>['web', 'auth', 'adminperm']], 
function(){
	Route::get('/security', 'SecurityController@index');
	Route::get('/saveOPC', 'SecurityController@saveOPC');
	Route::get('/configBackup', 'ConfigBackupController@index');
	Route::post('/backup', 'ConfigBackupController@backup');
	Route::post('/restore', 'ConfigBackupController@restore');

	
});

Route::group(['namespace' => 'admin', 'middleware' => ['web', 'auth', 'adminperm']], 
    function () {
        Route::get('/adminManagement', 'AdminlistController@adminManagement');
        Route::get('/adminInfo', 'AdminlistController@adminInfo');
        Route::get('/admin_dele', 'AdminlistController@admindele');
        Route::get('/saveAdmin', 'AdminlistController@saveAdmin');

        Route::get('/adminHistory', 'AdminhistoryController@adminhistory');
        Route::post('/deleteHistoryInfo', 'AdminhistoryController@adminhistory_del');
        Route::get('/clearHistory', 'AdminhistoryController@clearHistory');
        
});

Route::group(['namespace' => 'connect', 'middleware' => ['web', 'auth', 'adminperm']], 
    function () {
        Route::get('/connectingAdmin', 'connectingAdminController@index');
   		Route::get('/getDetailInfo', 'connectingAdminController@getDetailInfo');

		Route::get('/getHistoryDetailInfo', 'ConnectedHistoryController@getHistoryDetailInfo');
   		Route::get('/connectedHistory', 'ConnectedHistoryController@index');
});


