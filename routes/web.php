<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Task;

Route::get('/', function () {
	echo 'hi';
	return;
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

