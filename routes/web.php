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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/home', function () {
    return redirect(route('schedule_page'));
});

Route::get('/schedule_page', 'HomeController@schedule_page')->name('schedule_page');
Route::get('/showEditProfileForm', 'HomeController@showEditProfileForm')->name('showEditProfileForm');
Route::post('/editProfile', 'HomeController@editProfile')->name('editProfile');


Route::get('/push_notification', 'HomeController@push_notification');
Route::get('/pushNotification', 'HomeController@pushNotification')->name('pushNotification');

Route::get('/change_password','HomeController@showChangePasswordForm');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

Route::get('/createSchedule', 'HomeController@createSchedule')->name('createSchedule');
Route::get('/deleteSchedule', 'HomeController@deleteSchedule')->name('deleteSchedule');
Route::get('/updateSchedule', 'HomeController@updateSchedule')->name('updateSchedule');

Route::get('/createScheduleEvent', 'HomeController@createScheduleEvent')->name('createScheduleEvent');
Route::get('/deleteScheduleEvent', 'HomeController@deleteScheduleEvent')->name('deleteScheduleEvent');
