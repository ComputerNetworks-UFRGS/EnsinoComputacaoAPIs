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
use Mews\Purifier\Facades\Purifier;
use App\Models\LearningStage;
use App\Models\LearningObject;

class ObjectController extends Controller
{


    public function list(Request $req)
    {
        $this->authorize('has-permission', 'topics.list');
        return LearningObject::orderBy('name')->get();
    }

    public function detail($id)
    {
        $this->authorize('has-permission', 'topics.detail');
        return LearningObject::find($id);
    }

    public function create(Request $request)
    {
        $this->authorize('has-permission', 'topics.add');

        $object = new LearningObject();
        $object->name = $request->name;
        $object->description = $request->description;
        $object->learning_axis_id = $request->learning_axis_id;
        $object->age_group_id = $request->age_group_id;
        $object->save();
    }

    public function update($id, Request $request)
    {
        $this->authorize('has-permission', 'topics.edit');

        $object = LearningObject::find($id);
        $object->name = $request->name;
        $object->description = $request->description;
        $object->learning_axis_id = $request->learning_axis_id;
        $object->age_group_id = $request->age_group_id;
        $object->save();
    }

    public function delete($id)
    {
        $this->authorize('has-permission', 'topics.delete');

        // Topic::where('parent_id', $id)->delete();
        $object = LearningObject::find($id);
        $object->delete();
    }

}
