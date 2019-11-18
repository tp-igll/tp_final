<?php


Route::get('/', 'EtudiantController@create')->where('any', '.*');
Route::get('/liste','EtudiantController@index');
Route::post('/inscription','EtudiantController@store');
Route::get('/{id}/edit','EtudiantController@edit');
Route::put('/{id}/update','EtudiantController@update');
Route::delete('/{id}/destroy','EtudiantController@destroy');