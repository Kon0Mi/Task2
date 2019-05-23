@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Меню:</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <form action="/out" method="get" style="margin-left: 15px">
                            {{ csrf_field() }}
                        <select name="table">
                            <option value="worker">Сотрудники</option>
                            <option value="car">Авто</option>
                            <option value="orders">Заказы</option>
                            <input type="submit" name="submit" value="Показать" style="margin-left: 15px">
                        </select>
                        </form>
                        <a style="margin-left: 15px" href="/inputArgsSearch1">Информация о выполненых работах за период</a> <br>
                        <a style="margin-left: 15px" href="/inputArgsSearch2">Информация по расчету оплаты сотрудников за период</a>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
