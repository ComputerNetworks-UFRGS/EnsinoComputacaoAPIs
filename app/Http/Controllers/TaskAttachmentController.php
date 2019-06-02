<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskAttachment;

class TaskAttachmentController extends Controller
{

    public function create($id, Request $request)
    {
        $this->authorize('has-permission', 'task.create');
        $attachment = new TaskAttachment();
        $attachment->task_id = $id;
        $attachment->title = $request->title;
        $attachment->description = $request->description;
        $attachment->save();
        return 'ok';
    }

    public function delete($id, $attachment_id)
    {
        $this->authorize('has-permission', 'task.delete');
        $attachment = TaskAttachment::where('task_id', $id)->find($attachment_id);
        $attachment->delete();
        return 'ok';
    }

}
