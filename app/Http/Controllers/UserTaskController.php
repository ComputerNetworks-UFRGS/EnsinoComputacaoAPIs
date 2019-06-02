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
use Illuminate\Support\Facades\Gate;

class UserTaskController extends Controller
{
    public function list()
    {
        $this->authorize('has-permission', 'task.list');

        return Auth::user()->tasks()->get();
    }

    public function detail($id)
    {
        $this->authorize('has-permission', 'task.detail');

        $task = $this->findUserTask($id);
        return $task;
    }

    public function create(Request $request)
    // public function create(StoreTask $request)
    {
        $this->authorize('has-permission', 'task.create');

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->is_plugged = $request->is_plugged;
        $task->status = Task::STATUS_CREATED;
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

        if($task->status == Task::STATUS_DENIED_NEED_FIX) {
            $task->status = Task::STATUS_REVIEWED;
        } else if($task->status == Task::STATUS_PUBLISHED) {

            if (!Gate::allows('has-permission', 'task.no_review')) {
                $task->status = Task::STATUS_FOR_REVIEW;
                // TODO: notificar curadores...
            }
        }

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
        $this->authorize('has-permission', 'task.delete');

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
                },
                'reviews' => function($join) {
                    $join->orderBy('id', 'DESC');
                    $join->with([
                        'user' => function($join) {
                            $join->select(['id', 'name']);
                        }
                    ]);
                }
            ])
            ->where('user_id', Auth::user()->id)
            ->find($id);

        return $task;
    }

    public function publish($id)
    {
        $this->authorize('has-permission', 'task.edit');
        $task = $this->findUserTask($id);

        if (Gate::allows('has-permission', 'task.no_review')) {
            $task->status = Task::STATUS_PUBLISHED;
            $task->save();
        } else {
            if($task->status == Task::STATUS_CREATED || $task->status == Task::STATUS_REVIEWED) {
                $task->status = Task::STATUS_FOR_REVIEW;
                // TODO: notificar curadores...
                $task->save();
            }
        }


    }

}
