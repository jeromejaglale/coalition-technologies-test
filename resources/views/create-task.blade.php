@extends('template')

@section('title', 'Create')

@section('content')
<h1>Create Task</h1>
<div class="col-md-3">
<form method="POST" action="/create-task" class="row g-3">
    @csrf
	<div class="col-12">
	    <label for="name">Name</label>
	    <input type="text" id="name" name="name" required class="form-control">
	</div>
	<div class="col-12">
		<label for="priority">Priority</label>
		<select name="priority" id="priority" class="form-select">
			@for ($i = 1; $i <= $max_priority; $i++)
				<option value="{{ $max_priority }}">{{ $max_priority }}</option>
			@endfor
		</select> 
	</div>
	
	<div class="col-12">
	    <input type="submit" value="Create Task" class="btn btn-primary">
	</div>
</form>
</div>
@stop
