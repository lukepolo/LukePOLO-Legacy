<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Blogs;

class AdminController extends Controller
{
    public function getIndex()
    {
        return view('admin.index');
    }

    public function getCreate()
    {
        return view('admin.create');
    }

    public function getBlogs()
    {
        return view('admin.blogs', [
            'blogs' => Blogs::get()
        ]);
    }
}