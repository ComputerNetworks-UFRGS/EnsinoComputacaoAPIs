<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

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
        $this->authorize('has-permission', 'tag.create');

        $tag = new Tag();
        $tag->value = $request->value;
        $tag->key = $tag->makeKey($tag->value);
        $tag->published = (int) $request->published;
        $tag->save();
    }

    public function update($id, Request $request)
    {
        $this->authorize('has-permission', 'tag.edit');
        $tag = Tag::find($id);
        $tag->value = $request->value;
        $tag->key = $tag->makeKey($tag->value);
        $tag->published = (int) $request->published;
        $tag->save();
    }

    public function delete($id)
    {
        $this->authorize('has-permission', 'tag.delete');
        $object = Tag::find($id);
        $object->delete();
    }


}
