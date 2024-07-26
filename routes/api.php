<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login','AuthController@login');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('logout','AuthController@logout');
    Route::resource('requests','RequestController');
    Route::resource('request-items','RequestItemsController');
    Route::resource('extra-items','ExtraItemsController');
    Route::get('pending','RequestController@pending');
    Route::get('completed','RequestController@completed');
    Route::get('not_completed','RequestController@not_completed');
    Route::put('send_request/{id}','RequestController@send_request');
    Route::get('get_request_items/{id}','RequestItemsController@get_request_items');
    Route::get('get_finished_request_items/{id}','RequestItemsController@get_finished_request_items');
    Route::get('get_extra_items/{id}','ExtraItemsController@get_extra_items');
    Route::get('get_gates','RequestController@get_gates');
    Route::get('get_item_type','RequestController@get_item_type');
    Route::get('get_item_parent/{id}','RequestController@get_item_parent');
    Route::get('get_unit','RequestController@get_unit');
    Route::get('get_routes','AuthController@get_routes');
    Route::post('change_password','AuthController@change_password');
    Route::get('get_count','RequestController@get_count');
    Route::post('uploadImg','RequestItemsController@uploadImg');
    Route::get('get_images/{id}','RequestItemsController@get_images');
    Route::post('delete_image','RequestItemsController@delete_image');
    Route::get('get_export_count','ExportImportController@get_export_count');
    Route::get('export_requests', 'ExportImportController@export_requests');
    Route::get('export_request_items', 'ExportImportController@export_request_items');
    Route::get('confirm_export', 'ExportImportController@confirm_export');
    Route::post('import_requests', 'ExportImportController@import_requests');
    Route::post('import_items', 'ExportImportController@import_items');
    Route::post('import_users', 'ExportImportController@import_users');
    Route::resource('company-user','CompanyUserController');
    Route::resource('notification','NotificationController');
    Route::get('inquiry/{request_id}', 'RequestController@inquiry');
    Route::get('check_request/{id}','RequestController@check_request');
 });