<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Blog;
use App\Models\Mongo\Tag;

class BlogController extends Controller
{
    public function getIndex()
    {
        $tag = null;
        if(\Request::has('filter'))
        {
            $filters = null;

            $tag = Tag::where('name', '=', \Request::get('filter'))->first();

            if(empty($tag) === false)
            {
                $blogs = Blog::with('tags')->where('draft', '=', '0')->whereIn('tag_ids', [$tag->id])->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $blogs = Blog::with('tags')->where('draft', '=', '0')->orderBy('created_at', 'desc')->get();
            }
        }
        else
        {
            $blogs = Blog::with('tags')->where('draft', '=', '0')->orderBy('created_at', 'desc')->get();
        }

        return view('blog', [
            'blogs' => $blogs,
            'tags' => \Cache::rememberForever('tags', function()
            {
                return Tag::get();
            }),
            'tag' => $tag
        ]);
    }

    public function getView($blog_id)
    {
        $blog = Blog::with(['tags','comments' => function($query)
        {
            $query->with(['replies', 'replies.user'])->whereNull('parent_id');
        }, 'comments.user', 'comments.votes'])
        ->find($blog_id);

        \View::share('title', '{ LukePOLO | Blog : '.$blog->name);

        return view('blog.view', [
           'blog' => $blog
        ]);
    }

    public function getCreate()
    {
        return view('blog.form', [
            'tags' => Tag::get()
        ]);
    }

    public function postCreate()
    {
        $blog = Blog::create([
            'name' => \Request::get('name'),
            'draft' => \Request::get('draft'),
            'image' => \Request::get('image'),
            'html' => \Request::get('html'),
            'link_name' => \Request::get('link_name'),
            'preview_text' => \Request::get('preview_text')
        ]);

        $blog->tags()->attach(\Request::get('tags'));

        return redirect(action('\App\Http\Controllers\AdminController@getBlogs'));
    }

    public function getEdit($blog_id)
    {
        return view('blog.form', [
            'blog' => Blog::with('tags')->find($blog_id),
            'tags' => Tag::get()
        ]);
    }

    public function postEdit($blog_id)
    {
        $blog = Blog::with('tags')->find($blog_id);

        $blog->name = \Request::get('name');
        $blog->draft = \Request::get('draft');
        $blog->image = \Request::get('image');
        $blog->html = \Request::get('html');
        $blog->link_name = \Request::get('link_name');
        $blog->preview_text = \Request::get('preview_text');

        $blog->tags()->sync(\Request::get('tags'));

        $blog->save();

        return redirect(action('\App\Http\Controllers\AdminController@getBlogs'));
    }

    public function getDelete($blog_id)
    {
        Blog::find($blog_id)->delete();

        return redirect(action('\App\Http\Controllers\AdminController@getBlogs'));
    }
}
