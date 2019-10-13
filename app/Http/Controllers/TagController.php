<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{

    public function list(Request $req)
    {
        $this->authorize('has-permission', 'tag.list');
        return Tag::orderBy('value')->get();
    }

    public function detail($id)
    {
        $this->authorize('has-permission', 'tag.detail');
        return Tag::find($id);
    }

    public function create(Request $request)
    {
        $this->authorize('has-permission', 'tag.add');

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->key = $tag->makeKey($tag->name);
        $tag->published = false;
        $tag->save();
    }

    public function update($id, Request $request)
    {
        $this->authorize('has-permission', 'tag.edit');
        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->key = $tag->makeKey($tag->name);
        $tag->published = $request->published;
        $tag->save();
    }

    public function delete($id)
    {
        $this->authorize('has-permission', 'tag.delete');
        $object = Tag::find($id);
        $object->delete();
    }


}
