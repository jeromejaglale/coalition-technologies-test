<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

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

	// create task with highest priority by default
	$task = Task::create(['name' => $request->input('name'), 'priority' => Task::count()]);

	// only then update task priority, so the other tasks are reordered if needed
	$task->update_priority($request->input('priority'));

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

	$task->name = $request->input('name');
	$task->save();

	$task->update_priority($request->input('priority'));

	return redirect('/');
});

Route::post('/update-priorities', function (Request $request) {
	$old_priority = $request->input('old_priority');
	$new_priority = $request->input('new_priority');

	// find task whose priority was changed in the UI
	$task = Task::where('priority', $old_priority)->first();

	if($task == null) {
		abort(404);
	}

	$task->update_priority($new_priority);
});

Route::get('/delete-task/{id}', function ($id) {
	$task = Task::where('id', $id)->first();

	if($task == null) {
		abort(404);
	}

	// update task priority to highest first, so its deletion won't affect other priorities
	$task->update_priority(Task::count());

	$task->delete();

	return redirect('/');
});
