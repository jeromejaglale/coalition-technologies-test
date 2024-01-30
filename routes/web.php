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
	$task = Task::create($task_data);

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

	// if priority has been updated, update priority of other tasks
	if($task->priority != $old_priority) {
		if($task->priority > $old_priority) {
			$task_list = Task::where('priority', '>=', 1)->where('priority', '<=', $task->priority)->where('id', '!=', $task->id)->orderBy('priority')->get();
			$priority = 1;
			foreach ($task_list as $t) {
				$t->priority = $priority;
				$t->save();
				$priority++;
			}
		}
		else {
			$task_list = Task::where('priority', '>=', $task->priority)->where('id', '!=', $task->id)->orderBy('priority')->get();
			$priority = $task->priority + 1;
			foreach ($task_list as $t) {
				$t->priority = $priority;
				$t->save();
				$priority++;
			}
		}
	}

	return redirect('/');
});

Route::post('/update-priorities', function (Request $request) {
	$old_priority = $request->input('old_priority');
	$new_priority = $request->input('new_priority');

	Log::debug($old_priority);
	Log::debug($new_priority);

	$task = Task::where('priority', $old_priority)->first();

	if($task == null) {
		abort(404);
	}

	$task->priority = $new_priority;
	$task->save();

	// if priority has been updated, update priority of other tasks
	if($task->priority != $old_priority) {
		if($task->priority > $old_priority) {
			$task_list = Task::where('priority', '>=', 1)->where('priority', '<=', $task->priority)->where('id', '!=', $task->id)->orderBy('priority')->get();
			$priority = 1;
			foreach ($task_list as $t) {
				$t->priority = $priority;
				$t->save();
				$priority++;
			}
		}
		else {
			$task_list = Task::where('priority', '>=', $task->priority)->where('id', '!=', $task->id)->orderBy('priority')->get();
			$priority = $task->priority + 1;
			foreach ($task_list as $t) {
				$t->priority = $priority;
				$t->save();
				$priority++;
			}
		}
	}
});

Route::get('/delete-task/{id}', function ($id) {
	$task = Task::where('id', $id)->first();

	if($task == null) {
		abort(404);
	}

	$task->delete();

	return redirect('/');
});
