@extends('template')

@section('title', 'List')

@section('content')
<h1>Tasks</h1>

<p class="text-end">
	<a href="/create-task" class="btn btn-primary">Create new task</a>
</p>

<table class="table">
	<thead>
		<td>Priority</td>
		<td>Name</td>
		<td>Created</td>
		<td>Modified</td>
		<td></td>
	</thead>
	<tbody>
		@foreach ($task_list as $task)
			<tr>
				<td>{{ $task->priority }}</td>
				<td><a href="/edit-task/{{ $task->id }}">{{ $task->name }}</a></td>
				<td>{{ $task->created_at->format('M d, Y') }}</td>
				<td>{{ $task->updated_at->format('M d, Y') }}</td>
				<td><a href="/delete-task/{{ $task->id }}">Delete</a></td>
			</tr>
		@endforeach
	</tbody>
</table>

@stop
