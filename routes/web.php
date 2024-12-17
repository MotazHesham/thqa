<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();  

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth','staff']], function () {

    Route::get('dropbox/getDropBoxFileLink/{id}', 'HomeController@getDropBoxFileLink')->name('dropbox.getDropBoxFileLink');
    Route::post('dropbox/index', 'HomeController@dropbox')->name('dropbox.index');
    Route::post('dropbox/update_refresh_token', 'HomeController@update_refresh_token')->name('dropbox.update_refresh_token');

    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Owners
    Route::delete('owners/destroy', 'OwnersController@massDestroy')->name('owners.massDestroy');
    Route::resource('owners', 'OwnersController');

    // Buildings
    Route::delete('buildings/destroy', 'BuildingsController@massDestroy')->name('buildings.massDestroy');
    Route::post('buildings/media', 'BuildingsController@storeMedia')->name('buildings.storeMedia');
    Route::post('buildings/ckmedia', 'BuildingsController@storeCKEditorImages')->name('buildings.storeCKEditorImages');
    Route::post('buildings/show_folder_files', 'BuildingsController@show_folder_files')->name('buildings.show_folder_files');
    Route::resource('buildings', 'BuildingsController');

    // Countries
    Route::delete('countries/destroy', 'CountriesController@massDestroy')->name('countries.massDestroy');
    Route::post('countries/get_cities', 'CountriesController@get_cities')->name('countries.get_cities');
    Route::resource('countries', 'CountriesController');

    // Cities
    Route::delete('cities/destroy', 'CitiesController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CitiesController');

    // Building Documents
    Route::delete('building-documents/destroy', 'BuildingDocumentsController@massDestroy')->name('building-documents.massDestroy');
    Route::post('building-documents/media', 'BuildingDocumentsController@storeMedia')->name('building-documents.storeMedia');
    Route::post('building-documents/ckmedia', 'BuildingDocumentsController@storeCKEditorImages')->name('building-documents.storeCKEditorImages');
    Route::get('building-documents/update_status/{id}/{status}', 'BuildingDocumentsController@update_status')->name('building-documents.update_status');
    Route::resource('building-documents', 'BuildingDocumentsController');

    // Building Saks
    Route::delete('building-saks/destroy', 'BuildingSaksController@massDestroy')->name('building-saks.massDestroy');
    Route::post('building-saks/media', 'BuildingSaksController@storeMedia')->name('building-saks.storeMedia');
    Route::post('building-saks/ckmedia', 'BuildingSaksController@storeCKEditorImages')->name('building-saks.storeCKEditorImages');
    Route::resource('building-saks', 'BuildingSaksController');

    // Building Folders
    Route::get('building-folders/delete_folder/{folder_id}', 'BuildingFoldersController@delete_folder')->name('building-folders.delete_folder');
    Route::post('building-folders/update_folder', 'BuildingFoldersController@update_folder')->name('building-folders.update_folder');
    Route::resource('building-folders', 'BuildingFoldersController');

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
