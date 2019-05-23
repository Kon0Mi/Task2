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

Route::get('/out', function(){ // вывод таблицы по названию таблицы
	// получаем колонки
	$columns = DB::select(' 
		SELECT column_name 
		FROM INFORMATION_SCHEMA.COLUMNS 
		WHERE TABLE_NAME=?',[$_GET['table']]);
	//получаем значения и делаем страничный вывод
	$source = DB::table($_GET['table'])->simplePaginate(15);
 return view('out',['source' => $source, 'columns' => $columns, 'table' => $_GET['table']]); //форма вывода таблицы из source с колонками и сохранением названия таблицы
});

Route::get('/delete/{table}', function($table){ // переход на форму удаления
	return view('delete', ['table' => $table, 'text' => '']);
});

Route::get('/deleteById', function(){ // удаление по Id
	DB::table($_GET['table'])->where('id', '=',$_GET['id'])->delete();
	return view('delete', ['table' => $_GET['table'], 'text' => 'Успешно!!!']);
});

Route::get('/add/{table}', function($table){ // переход на форму добавления 

	$columns = DB::select('
		SELECT column_name 
		FROM INFORMATION_SCHEMA.COLUMNS 
		WHERE TABLE_NAME=?',[$table]);
	
 return view('add',['columns' => $columns, 'table' => $table, 'text' => '']); //открытие формы добавления и печать определенных колонок из нужной таблицы
});

Route::get('/addNew', function(){ //добавление
	//получаем колонки для ассоциативного массива для insert'а
	$columns = DB::select(' 
		SELECT column_name 
		FROM INFORMATION_SCHEMA.COLUMNS 
		WHERE TABLE_NAME=?',[$_GET['table']]);
	$args = []; //массив для добавления
	foreach ($columns as $column) {
		if ($column->column_name === 'id') continue;
			$args[$column->column_name] = $_GET[$column->column_name]; //заполняем массив по типу <название колонки> => <значение колонки>
	};
	DB::table($_GET['table'])->insertGetId($args); //добавление
	return view('add',['columns' => $columns, 'table' => $_GET['table'], 'text' => 'Успешно!!!']);
});

Route::get('/update/{table}', function($table){ // переход на форму изменения 

	$columns = DB::select('
		SELECT column_name 
		FROM INFORMATION_SCHEMA.COLUMNS 
		WHERE TABLE_NAME=?',[$table]);
	
 return view('update',['columns' => $columns, 'table' => $table, 'text' => '']); //открытие формы изменения и печать определенных колонок из нужной таблицы
});

Route::get('/updateById', function(){ //изменение
    //получаем колонки для ассоциативного массива для update'а
	$columns = DB::select('
		SELECT column_name 
		FROM INFORMATION_SCHEMA.COLUMNS 
		WHERE TABLE_NAME=?',[$_GET['table']]);
	$args = [];//массив для изменения
	foreach ($columns as $column) {
		if ($column->column_name === 'id') continue;
			$args[$column->column_name] = $_GET[$column->column_name]; //заполняем массив по типу <название колонки> => <значение колонки>
	};
	DB::table($_GET['table'])->where('id',$_GET['id'])->update($args); //изменение
	return view('update',['columns' => $columns, 'table' => $_GET['table'], 'text' => 'Успешно!!!']);
});

Route::get('/inputArgsSearch1', function(){
	return view('inputArgs', ['type' => 1] ); //открытие формы для заполнения полей и сохранение типа (1 - заказы в период, 2 - оплата рабочим за часы)
});

Route::get('/inputArgsSearch2', function(){
	return view('inputArgs', ['type' => 2] ); //открытие формы для заполнения полей и сохранение типа (1 - заказы в период, 2 - оплата рабочим за часы)
});

Route::get('/outSearch/{type}', function($type){
	if ($type == 1){

		$source = DB::table('orders')->where([['end','>',$_GET['begin']],['end','<',$_GET['end']]])->get(); //получаем все выполненые работы от GET[begin] до GET[end]

		$columns = DB::select("
			SELECT column_name 
			FROM INFORMATION_SCHEMA.COLUMNS 
			WHERE TABLE_NAME='orders'");

		return view('out',['source' => $source, 'columns' => $columns, 'table' => '---']); // выводим их
	};
	if ($type == 2){
		// получаем всех рабочих с суммой их часов за указаный период
		$source = DB::select(" 
			SELECT worker.id, worker.name, worker.surname, sum((worker.payment) * (orders.hourWork)) as PAY 
			FROM worker INNER JOIN orders on worker.id = orders.workerid
			WHERE orders.end > ? and orders.end < ?
			GROUP BY worker.id;", [$_GET['begin'], $_GET['end']]);

		$columns = DB::select("
			SELECT column_name 
			FROM INFORMATION_SCHEMA.COLUMNS 
			WHERE TABLE_NAME='worker'");
		foreach ($columns as $column) {
			if ($column->column_name === 'payment') $column->column_name = 'Pay'; //поменяем названия с payment - колонки таблицы рабочего, на Pay - оплату
		}
		return view('out',['source' => $source, 'columns' => $columns, 'table' => '---']); //выведем их 
	};
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
