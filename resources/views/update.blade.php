@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">{{ $text }}
                <div class="panel-heading">Изменение:</div>
                <form action="/updateById" method="get">
                	{{ csrf_field() }}
                	<input type="hidden" name="table" value="{{ $table }}">
    				@foreach($columns as $column )
    				<div style="padding-left: 10px">  
    					{{$column->column_name}}: 
    				</div>
    				<input style="margin-left: 10px; margin-bottom: 10px" type="text" name="{{$column->column_name}}">
    				@endforeach
    				<p><input style="margin-left: 10px" type="submit" name="submit"></p>
    			</form>	
                </div>
            </div>
        </div>
    </div>
</div>
@endsection