<?php

Route::post('uploadTmp', 'UtilsController@uploadTmp')->name('upload.tmp');
Route::delete('removeTmp/{arquivo}', 'UtilsController@removeTmp')->name('remove.tmp');
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
