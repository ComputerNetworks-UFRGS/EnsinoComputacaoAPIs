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

class UserTaskController extends Controller
{
    public function list()
    {
        return Auth::user()->tasks()->get();
    }

    public function detail($id)
    {
        $task = $this->findUserTask($id);
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

        if($request->skills) {
            $data = array_map(function($skill_id) {
                return [
                    'type' => TaskSkill::TYPE_PRIMARY,
                    'skill_id' => (int) $skill_id,
                ];
            }, $request->skills);

            $task->skills()->sync($data);
        }

        return 'ok';
    }

    public function update(Request $request, $id)
    // public function create(StoreTask $request, $id)
    {
        $this->authorize('has-permission', 'task.edit');

        $task = $this->findUserTask($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->is_plugged = $request->is_plugged;

        if($request->skills) {
            $data = array_map(function($skill_id) {
                return [
                    'type' => TaskSkill::TYPE_PRIMARY,
                    'skill_id' => (int) $skill_id,
                ];
            }, $request->skills);

            $task->skills()->sync($data);
        }

        $task->save();
    }

    public function delete($id)
    {
        $task = $this->findUserTask($id);
        $task->skills()->sync([]);
        $task->delete();
    }

    private function findUserTask($id)
    {
        $task = Auth::user()
            ->tasks()
            ->with([
                'skills' => function($join) {
                    $join->select([
                        'id AS habilidade_id',
                        'code AS habilidade_codigo',
                        'name AS habilidade_nome',
                        'age_group_id'
                    ]);
                    $join->with([
                        'ageGroup' => function($join) {
                            $join->select(['id', 'name']);
                        }
                    ]);
                }
            ])
            ->where('user_id', Auth::user()->id)
            ->find($id);

        return $task;
    }

}
