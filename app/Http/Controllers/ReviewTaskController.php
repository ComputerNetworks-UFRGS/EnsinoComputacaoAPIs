<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class ReviewTaskController extends Controller
{

    private $ids = [
        Task::STATUS_FOR_REVIEW,
        Task::STATUS_DENIED,
        Task::STATUS_DENIED_NEED_FIX,
        Task::STATUS_PUBLISHED,
    ];

    public function list()
    {
        // TODO: $this->authorize('has-permission', '');

        return Task::whereIn('status', $this->ids)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    public function detail($id)
    {
        // TODO: $this->authorize('has-permission', '');

        return Task::with([
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
        ->whereIn('status', $this->ids)
        ->find($id);
    }

    public function create(Request $request, $id)
    {
        // TODO: $this->authorize('has-permission', '');

        $ids = [
            Task::STATUS_DENIED,
            Task::STATUS_DENIED_NEED_FIX,
            Task::STATUS_PUBLISHED,
        ];

        $status = $request->status;

        if($status && in_array($status, $ids)) {
            $task = Task::find($id);
            $task->status = $status;
            $task->save();

            // TODO: registar comentário da revisão.

        }

    }

}
