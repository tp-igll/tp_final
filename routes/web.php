<?php


Route::get('/', 'EtudiantController@create');
Route::get('/Inscription', 'EtudiantController@create');
Route::get('/Liste', 'EtudiantController@create');

Route::get('/liste_other/{id}', 'EtudiantController@index');
Route::post('/inscription','EtudiantController@store');
Route::put('/update/{numero}','EtudiantController@update');
Route::delete('/destroy/{numero}','EtudiantController@destroy');

Route::get('/liste_prof/{id}','ProfController@index');

Route::get('/type/{id}','CompteController@getType');