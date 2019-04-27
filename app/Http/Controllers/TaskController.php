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

            $query->whereHas('taskSkill', function($query) use($req) {
                $query->whereIn('skill_id', $req->skills);
            });

        })->when($req->ages, function($query) use($req) {

            $query->whereHas('skills', function($query) use($req) {
                $query->whereHas('ageGroup', function($query) use($req) {
                    $query->whereIn('code', $req->ages);
                });
            });

        })->when(isset($req->plugged), function($query) use($req) {

            $query->where('is_plugged', (int) $req->plugged);

        })->when($req->objects, function($query) use($req) {

            $query->whereHas('skills', function($query) use($req) {
                $query->whereHas('topic', function($query) use($req) {
                    $query->whereIn('id', $req->objects);
                });
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
        $task = Task::find($id);
        $task->skill = $task->mainSkill();
        $task->user = $task->creator();
        return $task;
    }

    public function userDetail($id)
    {
        $task = $this->findUserTask($id);
        $task->skill = $task->mainSkill();
        $task->user = $task->creator();
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
