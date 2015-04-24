<?php


namespace App\Http\Controllers;

use \App\Models\Mongo\Tag;

class TagsController extends Controller
{
    public function getIndex()
    {
        return view('tags', [
            'tags' => Tag::get()
        ]);
    }

    public function getCreate()
    {
        return view('tags.form');
    }

    public function postCreate()
    {
        Tag::create([
            'name' => \Request::get('name'),
            'color' => \Request::get('color')
        ]);

        \Cache::forget('tags');

        return redirect(action('\App\Http\Controllers\TagsController@getIndex'));
    }

    public function postEdit($tag_id)
    {
        $tag_id = Tag::find($tag_id);

        $tag_id->name = \Request::get('name');
        $tag_id->color = \Request::get('color');

        $tag_id->save();

        \Cache::forget('tags');

        return redirect(action('\App\Http\Controllers\TagsController@getIndex'));
    }

    public function getEdit($technology_id)
    {
        return view('tags.form', [
            'tag' => Tag::find($technology_id)
        ]);
    }

    public function getDelete($technology_id)
    {
        Technology::find($technology_id)->delete();

        return redirect(action('\App\Http\Controllers\TagsController@getIndex'));
    }
}