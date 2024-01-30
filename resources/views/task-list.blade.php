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

@section('extra_javascript')
	<script>
	 	$(function() {
	 		// send Laravel CSRF token when doing AJAX requests
				$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

				// enable table rows to be re-ordered by drag and drop
		  	$('table').bootstrapTable().on('reorder-row.bs.table', function (e, tableData, oldRow, newRow) {
		  		const oldIndex = oldRow[0];
		  		const newIndex = newRow[0];

				if(oldIndex != newIndex) {
					$.ajax({
							url: '/update-priorities',
							type: 'POST',
							data: {
							old_priority: oldIndex,
							new_priority: newIndex
						},
						success: function (response) {
							location.reload();
						},
						error: function (error) {
							console.log('Error:', error);
						}
					});						
				}
		  	});
		});
	</script>
@stop
