<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    public function getIndex()
    {
        return view('blog');
    }

    public function getView($blog_id)
    {
        return view('blog.view');
    }
}
