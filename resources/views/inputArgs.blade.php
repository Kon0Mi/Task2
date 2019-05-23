@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Введите период:</div>
                <form action="/outSearch/{{$type}}" method="get">
                	От: <input style="margin-left: 15px" type="date" name="begin">
                	до: <input style="margin-left: 15px" type="date" name="end">
                	<input type="submit" name="submit">
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection