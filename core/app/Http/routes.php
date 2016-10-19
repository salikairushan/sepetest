<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'DashboardController@viewDashboard');

Route::post('login','LoginController@login');
Route::get('login','LoginController@index');
Route::get('logout','LogoutController@logout');


//user accounts
Route::group(['prefix' => 'accounts'], function () {
    Route::get('/','AccountsController@index');
});


//Resources
Route::group(['prefix' => 'resources'], function () {
    Route::get('/','ResourceController@index');
    Route::get('create','ResourceController@create');
    Route::get('{id}/edit','ResourceController@edit');
});

//API
Route::group(['prefix' => 'api'],function(){
    Route::group(['prefix' => 'accounts'],function(){
        Route::post('getUsers','API\AccountsController@getUers');
        Route::post('updateUser','API\AccountsController@updateUser');
        Route::post('insertUser','API\AccountsController@newUser');
    });
    Route::group(['prefix' => 'resources'],function(){
        Route::get('/','API\ResourceController@getAllResources');
        Route::post('create','API\ResourceController@createResource');
        Route::get('{id}','API\ResourceController@getResource');
        Route::post('{id}','API\ResourceController@updateResource');
    });
});

/**
 * Author :- Buwaneka Boralessa
 *
 * Time Table Section
 *
 * sample endpoint - 'timetable/batch'
 */
Route::group(['prefix' => 'timetable'],function() {
    /**
     * Page viewing end points
     */
    Route::get('batch', 'TimeTableController\TimeTableController@viewBatchTimeTable');
    Route::get('hall', 'TimeTableController\TimeTableController@viewHallTimeTable');
    Route::get('lab', 'TimeTableController\TimeTableController@viewLabTimeTable');
    Route::get('configurations', 'TimeTableController\TimeTableController@viewTimeTableConfig');

    /**
     * Ajax requests
     */
    Route::post('getTimeTableLayout', 'TimeTableController\TimeTableController@getTimeTableLayout');
});

/**
 * Author :- Buwaneka Boralessa
 *
 * Notifications Section
 *
 * sample endpoint - 'notifications/saveNotification'
 */
Route::group(['prefix' => 'notifications'],function(){
    Route::post('saveNotification','NotificationsController@insertNotification');
    Route::post('browseNotification','NotificationsController@browseNotification');
    Route::post('markAsReadNotification','NotificationsController@markAsReadNotification');
});

/**
 * Author :- Buwaneka Boralessa
 *
 * ------ TESTING  -------
 * Algorithm testing route
 */
Route::get('/testing', 'TimeTableController\AlgorithmController@viewResult');


/**
 *                  Exposed to Out Side
 * -----------------------------------------------------
 *                    SLIIT - RMS API
 * -----------------------------------------------------
 *
 *  -> VERSION 01
 *
 * API version 1 routing group for cross release purpose
 *
 * include all api->v1 related endpoints to this group
 * when creating new api end points create folder inside API\V1 directory with proper identifiers
 * and add namespace
 *
 * Example End point :- api/v1/timetable/getHallTimeTable
 *
 */
Route::group(['namespace' => 'API\V1','prefix' => 'api/v1'], function(){
    /**
     * Author :- Buwaneka Boralessa
     *
     * Time Table API endpoints
     */
    Route::group(['prefix' => 'timetable'],function() {
        Route::get('getBatchTimeTable', 'TimeTableController\TimeTableControllerAPI@getBatchTimeTable');
        Route::get('getHallTimeTable', 'TimeTableController\TimeTableControllerAPI@getHallTimeTable');
        Route::get('getLabTimeTable', 'TimeTableController\TimeTableControllerAPI@getLabTimeTable');
    });
});

Route::get('mail/queue','MailNotifitionController@helloWorld');