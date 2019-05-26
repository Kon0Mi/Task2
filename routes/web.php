<?php

Route::get('/', function () { //входной роут в программу
    return view('begin');
});

Route::post('/input', function(){ // авторизация
	return view('auth/login');
});

Route::post('/registration', function(){ //регистрация
	return view('auth/register');
});

Route::get('/out', 'ShowInfoController@show');

Route::get('/delete/{table}', 'ChangeTableController@goDelete');

Route::get('/deleteById', 'ChangeTableController@deleteById');

Route::get('/add/{table}', 'ChangeTableController@goAdd');

Route::get('/addNew', 'ChangeTableController@addNew');

Route::get('/update/{table}', 'ChangeTableController@goUpdate');

Route::get('/updateById', 'ChangeTableController@updateById');

Route::get('/inputArgsSearch1', function(){
	return view('inputArgs', ['type' => 1] ); //открытие формы для заполнения полей и сохранение типа (1 - заказы в период, 2 - оплата рабочим за часы)
});

Route::get('/inputArgsSearch2', function(){
	return view('inputArgs', ['type' => 2] ); //открытие формы для заполнения полей и сохранение типа (1 - заказы в период, 2 - оплата рабочим за часы)
});

Route::get('/outSearch/{type}', 'ShowInfoController@outSearch');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
