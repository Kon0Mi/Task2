<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChangeTableController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function goDelete(Request $request, $table)
    {
        return view('delete', ['table' => $table, 'text' => '']);
    }

    public function deleteById(Request $request) {
        DB::table($request->input('table'))->where('id', '=',$request->input('id'))->delete();
        return view('delete', ['table' => $request->input('table'), 'text' => 'Успешно!!!']);
    }

    public function goAdd(Request $request, $table)
    {
        $columns = DB::select('
            SELECT column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME=?',[$table]);
    
        return view('add',['columns' => $columns, 'table' => $table, 'text' => '']); //открытие формы добавления и печать определенных колонок из нужной таблицы
    }

    public function addNew(Request $request) 
    {
        $columns = DB::select(' 
            SELECT column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME=?',[$request->input('table')]);
        $args = []; //массив для добавления
        foreach ($columns as $column) 
            {
            if ($column->column_name === 'id') continue;
                $args[$column->column_name] = $_GET[$column->column_name]; //заполняем массив по типу <название колонки> => <значение колонки>
            }
        DB::table($request->input('table'))->insertGetId($args); //добавление
        return view('add',['columns' => $columns, 'table' => $request->input('table'), 'text' => 'Успешно!!!']);
    }

    public function goUpdate(Request $request, $table)
    {
        $columns = DB::select('
            SELECT column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME=?',[$table]);
    
        return view('update',['columns' => $columns, 'table' => $table, 'text' => '']); //открытие формы изменения и печать определенных колонок из нужной таблицы
    }

    public function updateById(Request $request) 
    {
            //получаем колонки для ассоциативного массива для update'а
        $columns = DB::select('
            SELECT column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME=?',[$request->input('table')]);
        $args = [];//массив для изменения
        foreach ($columns as $column) 
        {
            if ($column->column_name === 'id') continue;
                $args[$column->column_name] = $_GET[$column->column_name]; //заполняем массив по типу <название колонки> => <значение колонки>
        };
        DB::table($request->input('table'))->where('id',$request->input('id'))->update($args); //изменение
        return view('update',['columns' => $columns, 'table' => $request->input('table'), 'text' => 'Успешно!!!']);
    }
}
