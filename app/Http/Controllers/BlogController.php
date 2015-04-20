<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Blogs;

class BlogController extends Controller
{
    public function getIndex()
    {
        return view('blog', [
            'blogs' => Blogs::where('draft', '=', '0')->get()
        ]);
    }

    public function getView($blog_id)
    {
        $blog = Blogs::find($blog_id);
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
        Blogs::create([
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
            'blog' => Blogs::find($blog_id)
        ]);
    }

    public function postEdit($blog_id)
    {
        $blog = Blogs::find($blog_id);

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
        Blogs::find($blog_id)->delete();

        return redirect(action('\App\Http\Controllers\AdminController@getBlogs'));
    }
}
