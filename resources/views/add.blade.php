@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">{{ $text }}
                <div class="panel-heading">Добавление:</div>
                <form action="/addNew" method="get">
                	{{ csrf_field() }}
                	<input type="hidden" name="table" value="{{ $table }}">
    				@foreach($columns as $column )
    				@if ($column->column_name === 'id') 
                	@continue
                	@endif
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