@extends('template')

@section('title', 'List')

@section('content')
<h1>Tasks</h1>

<p class="text-end">
	<a href="/create-task" class="btn btn-primary">Create new task</a>
</p>

<table class="table" data-reorderable-rows="true" data-use-row-attr-func="true">
	<thead>
		<tr>
			<th>Priority</th>
			<th>Name</th>
			<th>Created</th>
			<th>Modified</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($task_list as $task)
			<tr data-priority="{{ $loop->index }}">
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
