@extends('template')

@section('title', 'Edit')

@section('content')
<form method="POST" action="/edit-task/{{ $task->id }}">
    @csrf

    <label for="name">Name</label><br>
    <input type="text" id="name" name="name" value="{{ $task->name }}" required>

	<label for="priority">Priority</label>
	<select name="priority" id="priority">
		@for ($i = 1; $i <= $max_priority; $i++)
			<option value="{{ $i }}" {{ $task->priority == $i ? 'selected' : ''}}>{{ $i }}</option>
		@endfor
	</select> 

    <input type="submit" value="Update Task">
</form>
@stop
