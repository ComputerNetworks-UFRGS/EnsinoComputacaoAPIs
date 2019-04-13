<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\UserTask;
use App\Http\Requests\StoreTask;
use Auth;

class TaskController extends Controller
{
    public function list()
    {
        return Task::paginate(8);
    }

    public function userList()
    {
        return Auth::user()->tasks()->get();
    }

    public function create(StoreTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $user_id;
        $task->save();

        $user_task = new UserTask();
        $user_task->user_id = Auth::user()->id;
        $user_task->task_id = $task->id;
        $user_task->role = UserTask::ROLE_OWNER;
        $user_task->save();

    }

    public function update()
    {

    }

}
