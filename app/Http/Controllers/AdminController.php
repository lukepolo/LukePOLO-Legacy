<?php

namespace App\Http\Controllers;

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
        return view('admin.blog');
    }
}