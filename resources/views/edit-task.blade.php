@extends('template')

@section('title', 'Edit')

@section('content')
<h1>Edit Task</h1>
<div class="col-md-3">
<form method="POST" action="/edit-task/{{ $task->id }}" class="row g-3">
    @csrf
	<div class="col-12">
	    <label for="name">Name</label><br>
	    <input type="text" id="name" name="name" value="{{ $task->name }}" required class="form-control">
	</div>

	<div class="col-12">
		<label for="priority">Priority</label>
		<select name="priority" id="priority" class="form-select">
			@for ($i = 1; $i <= $max_priority; $i++)
				<option value="{{ $i }}" {{ $task->priority == $i ? 'selected' : ''}}>{{ $i }}</option>
			@endfor
		</select> 
	</div>

	<div class="col-12">
	    <input type="submit" value="Update Task" class="btn btn-primary">
	</div>
</form>
</div>
@stop
