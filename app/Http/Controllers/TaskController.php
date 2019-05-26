<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

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

        })
        ->where('status', Task::STATUS_PUBLISHED)
        ->get();
    }

    public function detail($id)
    {
        $task = Task::with([
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
            ->where('status', Task::STATUS_PUBLISHED)
            ->find($id);

        return $task;
    }

}
