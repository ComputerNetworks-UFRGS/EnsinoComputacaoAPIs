<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\UserTask;
use App\Models\TaskSkill;
use App\Models\Skill;
use App\Http\Requests\StoreTask;
use Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function list(Request $req)
    {
        return Task::when($req->skills, function($query) use ($req) {
            $skills = explode(',', $req->skills);
            $skills = array_map(function($i) {
                return (int) $i;
            }, $skills);
            $query->whereHas('taskSkill', function($query) use($skills) {
                $query->whereIn('skill_id', $skills);
            });
        })->get();
    }

    public function userList()
    {
        $tasks = Auth::user()->tasks()->get();
        foreach($tasks as $task) {
            $task->skill = $task->mainSkill();
        }
        return $tasks;
    }

    public function detail($id)
    {
        return Task::find($id);
    }

    public function userDetail($id)
    {
        $task = $this->findUserTask($id);
        $task->skill = $task->mainSkill();
        return $task;
    }

    public function create(Request $request)
    // public function create(StoreTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->is_plugged = $request->is_plugged;
        $task->save();

        $user_task = new UserTask();
        $user_task->user_id = Auth::user()->id;
        $user_task->task_id = $task->id;
        $user_task->role = UserTask::ROLE_OWNER;
        $user_task->save();

        if($request->skill) {
            $task->addSkill($request->skill);
        }

        return 'ok';
    }

    public function update(Request $request, $id)
    // public function create(StoreTask $request, $id)
    {
        $task = $this->findUserTask($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->is_plugged = $request->is_plugged;

        if($request->skill) {
            $task->taskSkill()->delete();
            $task->addSkill($request->skill);
        }

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
