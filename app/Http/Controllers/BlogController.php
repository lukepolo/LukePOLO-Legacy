<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Blog;

class BlogController extends Controller
{
    public function getIndex()
    {
        return view('blog', [
            'blogs' => Blog::where('draft', '=', '0')->get()
        ]);
    }

    public function getView($blog_id)
    {
        $blog = Blog::with(['comments' => function($query)
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
        return view('blog.form');
    }

    public function postCreate()
    {
        Blog::create([
            'name' => \Request::get('name'),
            'draft' => \Request::get('draft'),
            'image' => \Request::get('image'),
            'tags' => \Request::get('tags'),
            'html' => \Request::get('html'),
            'link_name' => \Request::get('link_name'),
            'preview_text' => \Request::get('preview_text')
        ]);

        return redirect(action('\App\Http\Controllers\AdminController@getBlogs'));
    }

    public function getEdit($blog_id)
    {
        return view('blog.form', [
            'blog' => Blog::find($blog_id)
        ]);
    }

    public function postEdit($blog_id)
    {
        $blog = Blog::find($blog_id);

        $blog->name = \Request::get('name');
        $blog->draft = \Request::get('draft');
        $blog->image = \Request::get('image');
        $blog->tags = \Request::get('tags');
        $blog->html = \Request::get('html');
        $blog->link_name = \Request::get('link_name');
        $blog->preview_text = \Request::get('preview_text');

        $blog->save();

        return redirect(action('\App\Http\Controllers\AdminController@getBlogs'));
    }

    public function getDelete($blog_id)
    {
        Blog::find($blog_id)->delete();

        return redirect(action('\App\Http\Controllers\AdminController@getBlogs'));
    }
}
