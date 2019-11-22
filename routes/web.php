<?php


Route::get('/', 'EtudiantController@create')->where('any', '.*');
Route::get('/liste','EtudiantController@index');
Route::post('/inscription','EtudiantController@store');
Route::put('/{matricule}/update','EtudiantController@update');
Route::delete('/destroy/{numero}','EtudiantController@destroy');