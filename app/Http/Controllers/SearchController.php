<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Blog;

class SearchController extends Controller
{
    public function getIndex()
    {
        $blogs = Blog::where('name', 'like', '%' . \Request::get('q') . '%')
            ->get();

        $results = [];
        foreach ($blogs as $blog) {
            $results[] = [
                'id' => $blog->id,
                'text' => $blog->name,
                'action' => action('\App\Http\Controllers\BlogController@getView', [$blog->link_name])
            ];
        }

        return response($results);
    }
}
