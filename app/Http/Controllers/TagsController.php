<?php


namespace App\Http\Controllers;

use App\Http\Requests\TagFormRequest;
use App\Models\Mongo\Tag;

/**
 * Class TagsController
 * @package App\Http\Controllers
 */
class TagsController extends Controller
{
    /**
     * The main tag view
     * @return mixed
     */
    public function getIndex()
    {
        return view('tags', [
            'tags' => Tag::get()
        ]);
    }

    /**
     * The create form
     * @return mixed
     */
    public function getCreate()
    {
        return view('tags.form');
    }

    /**
     * Creates a new tag
     * @param TagFormRequest $request
     * @return mixed
     */
    public function postCreate(TagFormRequest $request)
    {
        Tag::create(\Request::except('_token'));

        \Cache::forget('tags');

        return redirect(action('\App\Http\Controllers\TagsController@getIndex'));
    }

    /**
     * The update form
     * @param $technology_id
     * @return mixed
     */
    public function getEdit($technology_id)
    {
        return view('tags.form', [
            'tag' => Tag::find($technology_id)
        ]);
    }

    /**
     * Update a tag
     * @param $tagID
     * @param TagFormRequest $request
     * @return mixed
     */
    public function postEdit($tagID, TagFormRequest $request)
    {
        $tag = Tag::find($tagID);
        $tag->fill(\Request::except('_token'));

        \Cache::forget('tags');

        return redirect(action('\App\Http\Controllers\TagsController@getIndex'));
    }

    /**
     * Deletes a tag
     * @param $tagID
     * @return mixed
     */
    public function getDelete($tagID)
    {
        Tag::find($tagID)->delete();

        return redirect(action('\App\Http\Controllers\TagsController@getIndex'));
    }
}