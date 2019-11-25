<?php


Route::get('/', 'EtudiantController@create')->where('any', '.*');
Route::get('/liste/{id}','EtudiantController@index');
Route::post('/inscription','EtudiantController@store');
Route::put('/update/{numero}','EtudiantController@update');
Route::delete('/destroy/{numero}','EtudiantController@destroy');