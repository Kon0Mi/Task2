@extends('layouts.app')
@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Таблица:</div>
                	<table>
                			<tr>
                				@foreach($columns as $column )
                				<th style="padding-right: 50px">  {{$column->column_name}}  </th>
                				@endforeach
                			</tr>
                		@foreach($source as $element)
                		<tr>
                		@foreach($element as $info)
                		<td>
                			{{ $info }} 
                		</td>
                		@endforeach
                	</tr>
                	@endforeach
					</table>
					@if($table === "worker" || $table === "orders" || $table === "car") 
					<a href="/delete/{{ $table }}" style="padding-right: 20px">Удалить</a>
					<a href="/add/{{ $table }}" style="padding-right: 20px">Добавить</a>
					<a href="/update/{{ $table }}" style="padding-right: 20px">Изменить</a>
					{{ $source->links() }}
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection