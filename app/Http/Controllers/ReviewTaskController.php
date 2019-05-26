<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Review;
use Auth;

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
        TODO: $this->authorize('has-permission', 'review.list');

        return Task::whereIn('status', $this->ids)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    public function detail($id)
    {
        TODO: $this->authorize('has-permission', 'review.detail');

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
        ->whereIn('status', $this->ids)
        ->find($id);
    }

    public function create(Request $request, $id)
    {
        TODO: $this->authorize('has-permission', 'review.evaluate|task.edit');

        $review = new Review();
        $review->task_id = (int) $id;
        $review->user_id = Auth::user()->id;
        $review->comment = $request->comment;
        $review->save();

    }

    public function setStatus(Request $request, $id)
    {
        TODO: $this->authorize('has-permission', 'review.evaluate');

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
        }

    }


}
