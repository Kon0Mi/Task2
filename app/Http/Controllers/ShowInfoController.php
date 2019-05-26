<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowInfoController extends Controller
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

    public function show(Request $request){
        // получаем колонки
        $columns = DB::select(' 
            SELECT column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME=?',[$request->input('table')]);
        //получаем значения и делаем страничный вывод
        $source = DB::table($request->input('table'))->simplePaginate(15);
        return view('out',['source' => $source, 'columns' => $columns, 'table' => $request->input('table')]); //форма вывода таблицы из source с колонками и сохранением названия таблицы
    }

    public function outSearch(Request $request, $type)
    {
    if ($type == 1){

        $source = DB::table('orders')->
        where([['end','>',$request->input('begin')],['end','<',$request->input('end')]])->
        get(); //получаем все выполненые работы от GET[begin] до GET[end]

        $columns = DB::select("
            SELECT column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME='orders'");

        return view('out',['source' => $source, 'columns' => $columns, 'table' => '---']); // выводим их
    };
    if ($type == 2){
        // получаем всех рабочих с суммой их часов за указаный период
        $source = DB::select(" 
            SELECT worker.id, worker.name, worker.surname, sum((worker.payment) * (orders.hourwork)) as PAY 
            FROM worker INNER JOIN orders on worker.id = orders.workerid
            WHERE orders.end > ? and orders.end < ?
            GROUP BY worker.id;", [$request->input('begin'), $request->input('end')]);

        $columns = DB::select("
            SELECT column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME='worker'");
        foreach ($columns as $column) {
            if ($column->column_name === 'payment') $column->column_name = 'Pay'; //поменяем названия с payment - колонки таблицы рабочего, на Pay - оплату
        }
        return view('out',['source' => $source, 'columns' => $columns, 'table' => '---']); //выведем их 
    };
    }
}
