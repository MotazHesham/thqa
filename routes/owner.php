<?php

use Illuminate\Support\Facades\Route;  

Route::group(['prefix' => 'owner', 'as' => 'owner.', 'namespace' => 'Owner', 'middleware' => ['auth','owner']], function () {

    Route::get('/', 'HomeController@index')->name('home'); 

    // Buildings
    Route::delete('buildings/destroy', 'BuildingsController@massDestroy')->name('buildings.massDestroy');
    Route::post('buildings/media', 'BuildingsController@storeMedia')->name('buildings.storeMedia');
    Route::post('buildings/ckmedia', 'BuildingsController@storeCKEditorImages')->name('buildings.storeCKEditorImages');
    Route::resource('buildings', 'BuildingsController');
    
    // Building Documents
    Route::delete('building-documents/destroy', 'BuildingDocumentsController@massDestroy')->name('building-documents.massDestroy');
    Route::post('building-documents/media', 'BuildingDocumentsController@storeMedia')->name('building-documents.storeMedia');
    Route::post('building-documents/ckmedia', 'BuildingDocumentsController@storeCKEditorImages')->name('building-documents.storeCKEditorImages');
    Route::resource('building-documents', 'BuildingDocumentsController');

    // Building Saks
    Route::delete('building-saks/destroy', 'BuildingSaksController@massDestroy')->name('building-saks.massDestroy');
    Route::post('building-saks/media', 'BuildingSaksController@storeMedia')->name('building-saks.storeMedia');
    Route::post('building-saks/ckmedia', 'BuildingSaksController@storeCKEditorImages')->name('building-saks.storeCKEditorImages');
    Route::resource('building-saks', 'BuildingSaksController');

    // Owners Report
    Route::delete('owners-reports/destroy', 'OwnersReportController@massDestroy')->name('owners-reports.massDestroy');
    Route::resource('owners-reports', 'OwnersReportController');

    // Report Buildings
    Route::delete('report-buildings/destroy', 'ReportBuildingsController@massDestroy')->name('report-buildings.massDestroy');
    Route::resource('report-buildings', 'ReportBuildingsController');

    // Report Saks
    Route::delete('report-saks/destroy', 'ReportSaksController@massDestroy')->name('report-saks.massDestroy');
    Route::resource('report-saks', 'ReportSaksController');

    Route::get('map','MapController@index')->name('map.index');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
