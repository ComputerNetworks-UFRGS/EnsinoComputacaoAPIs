<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskAttachment;
use Illuminate\Support\Facades\Storage;
use Auth;

class TaskAttachmentController extends Controller
{

    public function list($id)
    {
        $task = Auth::user()
            ->tasks()
            ->with('attachments')
            ->where('user_id', Auth::user()->id)
            ->find($id);

        return $task->attachments;
    }

    public function create($id, Request $request)
    {

        $path = '';
        if ($request->hasFile('file')) {
            $extension = $request->file->extension();
            $fileName = md5(microtime(true)) . '_' . $id . '.' . $extension;
            $path = $request->file->move('attachments', $fileName);
        }

        $this->authorize('has-permission', 'task.create');
        $attachment = new TaskAttachment();
        $attachment->task_id = $id;
        $attachment->title = $request->title;
        $attachment->description = $request->description;
        $attachment->path = $path;
        $attachment->save();
        return 'ok';
    }

    public function delete($id, $attachment_id)
    {
        $this->authorize('has-permission', 'task.delete');
        $attachment = TaskAttachment::where('task_id', $id)->find($attachment_id);
        @unlink($attachment->path);
        $attachment->delete();
        return 'ok';
    }

}
