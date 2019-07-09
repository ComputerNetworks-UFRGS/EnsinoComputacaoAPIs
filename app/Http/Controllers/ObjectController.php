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

    public function tree()
    {

        // TODO: retornar árvore de objetos..
        return [];

        // $this->authorize('has-permission', 'topics.list');

        // // find learging stage
        // $learningStage = LearningStage::where('code', LearningStage::CODE_ENSINO_COMPUTACIONAL)->first();
        // $types = TopicType::where('learning_stage_id', $learningStage->id)->get();
        // if(count($types) <= 0) {
        //     return [];
        // }

        // // find head and list tree levels
        // $tree_struct = [];
        // $tree_types = [];
        // $head_type = false;
        // foreach($types as $type) {
        //     if($type->is_head) {
        //         $head_type = $type->id;
        //     }
        //     $tree_struct[] = "topic_type_{$type->id}";
        //     $tree_types[] = $type->id;
        // }

        // // split head and trunk
        // $root = $tree_struct[count($tree_struct) - 1];
        // $trunk = array_slice($tree_struct, 0, count($tree_struct) - 1);

        // // root
        // $query = DB::table('topics AS ' . $root)
        //     ->where($root . '.type_id', $head_type);

        // $select = [
        //     "{$root}.id AS {$root}_id",
        //     "{$root}.name as {$root}_nome",
        //     // 's.id AS id',
        //     // 's.name AS title',
        //     // 's.code AS code',
        // ];

        // // trunk
        // $lastBranch = false;
        // foreach($trunk as $branch) {
        //     $parent = $lastBranch ? $lastBranch : $root;

        //     $query->leftJoin("topics AS {$branch}", "{$branch}.parent_id", '=', "{$parent}.id");
        //     $select[] = "{$branch}.id as {$branch}_id";
        //     $select[] = "{$branch}.name as {$branch}_nome";

        //     $lastBranch = $branch;
        // }

        // // leafs
        // // $parent = $lastBranch ? $lastBranch : $root;
        // // $query->leftJoin('skills AS s', 's.topic_id', '=', "{$parent}.id");

        // $query->select($select);


        // $nodes = $query->get();


        // $to_remove = [];
        // foreach($tree_struct as $tree_node) {
        //     $to_remove[] = $tree_node . '_id';
        //     $to_remove[] = $tree_node . '_nome';
        // }

        // $groupFn = function($nodes, $depth) use(&$groupFn, $tree_struct, $tree_types, $to_remove) {

        //     if($depth > 0) {

        //         $id = $tree_struct[$depth - 1] . '_id';
        //         $title = $tree_struct[$depth - 1] . '_nome';

        //         $type = $tree_types[count($tree_types) - $depth];
        //         $children_type = isset($tree_types[count($tree_types) - $depth + 1]) ? $tree_types[count($tree_types) - $depth + 1] : false;

        //         return $nodes->groupBy($id)
        //             ->map(function($items, $key) use(&$groupFn, $id, $title, $type, $depth, $children_type) {

        //                 $is_left = $depth == 1;

        //                 return [
        //                     'id' => $items[0]->{$id},
        //                     'title' => $items[0]->{$title},
        //                     'type' => $type,
        //                     'children_type' => $children_type,
        //                     'is_leaf' => $is_left,
        //                     'items' => $is_left ? false : $groupFn($items, $depth - 1),
        //                 ];
        //             })
        //             ->sortBy('title')
        //             ->values();

        //     } else {

        //         return $nodes->map(function($item) use($to_remove) {
        //             return collect($item)->except($to_remove);
        //         });

        //     }

        // };

        // return [
        //     'structure' => $tree_types,
        //     // 'types' => $types,
        //     'tree' => [
        //         'title' => $learningStage->name,
        //         'items' => $groupFn($nodes, count($tree_struct)),
        //     ],
        // ];

    }

    public function create(Request $request)
    {
        $this->authorize('has-permission', 'topics.add');

        $object = new LearningObject();
        $object->name = $request->name;
        $object->description = $request->description;
        $object->learning_axis_id = $request->learning_axis_id;
        $object->save();
    }

    public function update($id, Request $request)
    {
        $this->authorize('has-permission', 'topics.edit');

        $object = LearningObject::find($id);
        $object->name = $request->name;
        $object->description = $request->description;
        $object->learning_axis_id = $request->learning_axis_id;
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
