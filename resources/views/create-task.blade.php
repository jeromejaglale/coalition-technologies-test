@extends('template')

@section('title', 'Create')

@section('content')
<form method="POST" action="/create-task">
    @csrf

    <label for="name">Name</label><br>
    <input type="text" id="name" name="name" required>

	<label for="priority">Priority</label>
	<select name="priority" id="priority">
		@for ($i = 1; $i <= $max_priority; $i++)
			<option value="{{ $max_priority }}">{{ $max_priority }}</option>
		@endfor
	</select> 

    <input type="submit" value="Create Task">
</form>
@stop
