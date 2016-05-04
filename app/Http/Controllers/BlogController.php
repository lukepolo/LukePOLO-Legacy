<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogFormRequest;
use App\Models\Mongo\Blog;
use App\Models\Mongo\Tag;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    /**
     * Gets all the blogs for the admin view
     * @return mixed
     */
    public function getAdminIndex()
    {
        return view('admin.blogs', [
            'blogs' => Blog::orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Gets the blog page for the public
     * @return mixed
     */
    public function getPublicIndex()
    {
        $blogs = Blog::with('tags')->where('draft', '0')->orderBy('created_at', 'desc');

        $tag = null;
        if (\Request::has('filter')) {

            $tag = Tag::where('name', \Request::get('filter'))->first();

            if (!empty($tag)) {
                $blogs->whereIn('tag_ids', [$tag->id]);
            }
        }

        return view('blog', [
            'blogs' => $blogs->get(),
            'tags' => Tag::get(),
            'tag' => $tag
        ]);
    }

    /**
     * Views the blogs content
     * @param $blogID
     * @return mixed
     */
    public function getView($blogID)
    {
        $blog = Blog::with([
            'tags',
            'comments' => function ($query) {
                $query->with(['replies', 'replies.user'])->whereNull('parent_id');
            },
            'comments.user',
            'comments.votes'
        ])->find($blogID);

        \View::share('title', '{ LukePOLO | Blog : ' . $blog->name);

        return view('blog.view', [
            'blog' => $blog
        ]);
    }

    /**
     * Searches for blogs based on their query
     * @return mixed
     */
    public function getSearch()
    {
        $blogs = Blog::where('name', 'like', '%' . \Request::get('q') . '%')->get();

        $results = [];
        foreach ($blogs as $blog) {
            $results[] = [
                'id' => $blog->id,
                'text' => $blog->name,
                'action' => action('BlogController@getView', [$blog->link_name])
            ];
        }

        return response($results);
    }

    /**
     * Gets the create form
     * @return mixed
     */
    public function getCreate()
    {
        return view('blog.form', [
            'tags' => Tag::get()
        ]);
    }

    /**
     * Creates a blog
     * @param BlogFormRequest $request
     * @return mixed
     */
    public function postCreate(BlogFormRequest $request)
    {
        $blog = Blog::create(\Request::except(['_token', 'tags']));

        if (empty(\Request::get('tags')) === false) {
            $blog->tags()->attach(\Request::get('tags'));
        }

        return redirect(action('BlogController@getAdminIndex'));
    }

    /**
     * Gets the edit form
     * @param $blogID
     * @return mixed
     */
    public function getEdit($blogID)
    {
        return view('blog.form', [
            'blog' => Blog::with('tags')->find($blogID),
            'tags' => Tag::get()
        ]);
    }

    /**
     * Saves the updates to the blog
     * @param BlogFormRequest $request
     * @param $blogID
     * @return mixed
     */
    public function postEdit(BlogFormRequest $request, $blogID)
    {
        dd('ttest');
        $blog = Blog::with('tags')->find($blogID);

        dd(\Request::all());
        $blog->fill([
            \Request::except(\Request::except(['_token', 'tags']))
        ]);

        if (empty(\Request::get('tags')) === false) {
            $blog->tags()->sync(\Request::get('tags'));
        } else {
            $blog->tags()->sync([]);
        }

        $blog->save();

        return redirect(action('BlogController@getAdminIndex'));
    }

    /**
     * Deletes a blog
     * @param $blogID
     * @return mixed
     */
    public function getDelete($blogID)
    {
        Blog::find($blogID)->delete();

        return redirect(action('BlogController@getAdminIndex'));
    }
}
