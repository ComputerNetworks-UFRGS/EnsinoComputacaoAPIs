<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\UserTask;
use App\Http\Requests\StoreTask;
use Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function list()
    {
        return Task::get();
    }

    public function userList()
    {
        return Auth::user()->tasks()->get();
    }

    public function detail($id)
    {
        return Task::find($id);
    }

    public function userDetail($id)
    {
        return $this->findUserTask($id);
    }

    public function create(Request $request)
    // public function create(StoreTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();

        $user_task = new UserTask();
        $user_task->user_id = Auth::user()->id;
        $user_task->task_id = $task->id;
        $user_task->role = UserTask::ROLE_OWNER;
        $user_task->save();

        return 'ok';
    }

    public function update(Request $request, $id)
    // public function create(StoreTask $request, $id)
    {
        $task = $this->findUserTask($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();
    }

    public function delete($id)
    {
        $task = $this->findUserTask($id);
        $task->delete();
    }

    private function findUserTask($id)
    {
        return Auth::user()->tasks()
            ->where('user_id', Auth::user()->id)
            ->find($id);
    }

}
