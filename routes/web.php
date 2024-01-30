<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

// if priority of task with $task_id has been updated
// from $old_priority to $new_priority,
// update priority of other tasks accordingly
function update_other_priorities($task_id, $old_priority, $new_priority) {
	if($new_priority != $old_priority) {
		if($new_priority > $old_priority) {
			$task_list = Task::where('priority', '>=', 1)->where('priority', '<=', $new_priority)->where('id', '!=', $task_id)->orderBy('priority')->get();
			$priority = 1;
			foreach ($task_list as $t) {
				$t->priority = $priority;
				$t->save();
				$priority++;
			}
		}
		else {
			$task_list = Task::where('priority', '>=', $new_priority)->where('id', '!=', $task_id)->orderBy('priority')->get();
			$priority = $new_priority + 1;
			foreach ($task_list as $t) {
				$t->priority = $priority;
				$t->save();
				$priority++;
			}
		}
	}
}

Route::get('/', function () {
	$task_list = Task::orderBy('priority')->get();

	$data = [];
	$data['task_list'] = $task_list;

    return view('task-list', $data);
});

Route::get('/create-task', function () {
	$nb_tasks = Task::count();
	$max_priority = $nb_tasks + 1;

	$data = [];
	$data['max_priority'] = $max_priority;

    return view('create-task', $data);
});

Route::post('/create-task', function (Request $request) {
	$task_data = $request->all();
	$task = Task::create($task_data);

	update_other_priorities($task->id, Task::count(), $task->priority);

	return redirect('/');
});

Route::get('/edit-task/{id}', function ($id) {
	$task = Task::where('id', $id)->first();

	if($task == null) {
		abort(404);
	}

	$nb_tasks = Task::count();
	$max_priority = $nb_tasks;

	$data = [];
	$data['task'] = $task;
	$data['max_priority'] = $max_priority;

    return view('edit-task', $data);
});


Route::post('/edit-task/{id}', function ($id, Request $request) {

	$task = Task::find($id);

	if($task == null) {
		abort(404);
	}

	$old_priority = $task->priority;

	$task->name = $request->input('name');
	$task->priority = $request->input('priority');
	 
	$task->save();

	update_other_priorities($task->id, $old_priority, $task->priority);

	return redirect('/');
});

Route::post('/update-priorities', function (Request $request) {
	$old_priority = $request->input('old_priority');
	$new_priority = $request->input('new_priority');

	$task = Task::where('priority', $old_priority)->first();

	if($task == null) {
		abort(404);
	}

	$task->priority = $new_priority;
	$task->save();

	update_other_priorities($task->id, $old_priority, $task->priority);
});

Route::get('/delete-task/{id}', function ($id) {
	$task = Task::where('id', $id)->first();

	if($task == null) {
		abort(404);
	}

	$task->delete();

	return redirect('/');
});
