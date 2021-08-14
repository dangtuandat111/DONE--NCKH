<?php


namespace App\Http\Controllers\Auth;

use  App\Models;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use app\Http\Controllers\AuthController;
use app\Http\Controllers\Controller;	
use app\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\View;
use DB;
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


Route::get('/',function() {
	 return view("admin.login");
});

Route::group(['middleware' => 'guest'] , function() {
	Route::match(['get','post'],'login', ['as' => 'login', 'uses' =>'App\Http\Controllers\LoginController@index']);
});

Route::group(['middleware' => 'auth' ], function() {
	Route::group(['prefix' => 'admin'], function() {
		Route::group(['prefix' => 'hocphan'], function() {
			Route::get('thongtin', 'App\Http\Controllers\HocPhanController@getThongTin');
			Route::get('sua/{id_module}', 'App\Http\Controllers\HocPhanController@fixThongTin');
			Route::get('them', 'App\Http\Controllers\HocPhanController@addThongTin');
			Route::get('xoa/{id_module}', 'App\Http\Controllers\HocPhanController@deleteThongTin');
			Route::get('filter','App\Http\Controllers\HocPhanController@getFilter');

			Route::post('them', 'App\Http\Controllers\HocPhanController@postAdd');
			Route::post('sua/{id_module}', 'App\Http\Controllers\HocPhanController@postFix');
		});

		Route::group(['prefix' => 'teacher'], function() {
			Route::get('thongtin','App\Http\Controllers\GiangVienController@getThongTin');
			Route::get('sua/{ID_Teacher}', 'App\Http\Controllers\GiangVienController@fixThongTin');
			Route::get('them', 'App\Http\Controllers\GiangVienController@addThongTin');
			Route::get('xoa/{ID_Teacher}', 'App\Http\Controllers\GiangVienController@deleteThongTin');

			Route::post('them', 'App\Http\Controllers\GiangVienController@postAdd');
			Route::post('sua/{ID_Teacher}', 'App\Http\Controllers\GiangVienController@postFix');
		});

		Route::group(['prefix' => 'import'], function(){
			Route::get('lophocphan', 'App\Http\Controllers\importController@getModules_Class');
			Route::post('lophocphan',  'App\Http\Controllers\importController@postModules_Class');
			Route::get('giangvien', 'App\Http\Controllers\importController@getTeachers');
			Route::post('giangvien',  'App\Http\Controllers\importController@postTeachers');
			Route::get('phong', 'App\Http\Controllers\importController@getRoom');
			Route::post('phong',  'App\Http\Controllers\importController@postRoom');
			Route::get('hocphan', 'App\Http\Controllers\importController@getModules');
			Route::post('hocphan',  'App\Http\Controllers\importController@postModules');

			//Route::get('check', 'App\Http\Controllers\importController@getCheck');
		});

		Route::group(['prefix' => 'export'], function() {
			Route::post('giangvien',  'App\Http\Controllers\ExportController@postTeacher' );
			Route::post('thongke',  'App\Http\Controllers\ExportController@postThongKe' );
			
		});
		Route::group(['prefix' => 'module_class'],function()  {
			Route::get('thongtin','App\Http\Controllers\Module_classController@getThongTin');
			Route::get('filter','App\Http\Controllers\Module_classController@getFilter');
			Route::get('filterHP/{id}','App\Http\Controllers\Module_classController@getFilterHP');

		});
		Route::group(['prefix' => 'fix'],function()  {
			Route::get('thongtin','App\Http\Controllers\FixController@getThongTin');
			Route::get('getPaginate','App\Http\Controllers\FixController@getPaginate');
			Route::post('submitChange', 'App\Http\Controllers\FixController@submitChange');

			Route::get('yeucau',  'App\Http\Controllers\RequestFixController@getThongTin');
			Route::get('xacnhan/{id}',  'App\Http\Controllers\RequestFixController@Accept');
			Route::get('tuchoi/{id}',  'App\Http\Controllers\RequestFixController@Decline');

		});
		Route::group(['prefix' => 'assign'],function()  {
			Route::get('thongtin','App\Http\Controllers\AssignController@index');
			Route::post('filter', 'App\Http\Controllers\AssignController@getFilter');
			Route::post('submit', 'App\Http\Controllers\AssignController@submit');
			Route::get('list','App\Http\Controllers\AssignController@index2');
			Route::get('filterList', 'App\Http\Controllers\AssignController@getFilterList');

			Route::get('getTeacher/{id}','App\Http\Controllers\AssignController@getGV');
			Route::get('filter','App\Http\Controllers\AssignController@getFilter');
			Route::get('xoa/{ID_Module_Class}', 'App\Http\Controllers\AssignController@deleteThongTin');
		});
		Route::group(['prefix' => 'room'], function() {
			Route::get('thongtin','App\Http\Controllers\RoomController@index');
			Route::post('submit','App\Http\Controllers\RoomController@submit');
		});
		Route::group(['prefix' => 'thongke'], function() {
			Route::get('thongtin','App\Http\Controllers\ThongKeController@index');
		});

		//Test loi
		Route::get('testData','App\Http\Controllers\ThongKeController@testLoi');
	});
	Route::get('fullcalendar','App\Http\Controllers\ScheduleController@getAll');
	Route::get('calendar','App\Http\Controllers\ScheduleController@getOne');
	//Route::get('testCalendar','App\Http\Controllers\ScheduleController@testGet');
	Route::get('/home', ['as' => '/home' , 'uses' => 'App\Http\Controllers\LoginController@home']);
	Route::get('/logout', 'App\Http\Controllers\LoginController@Logout');



});








