<?php


namespace App\Http\Controllers;

use \App\Models\Mongo\Technologies;

class TechnologiesController extends Controller
{
    public function getIndex()
    {
        return view('technologies', [
            'technologies' => Technologies::get()
        ]);
    }

    public function getCreate()
    {
        return view('technologies.form');
    }

    public function postCreate()
    {
        Technologies::create([
            'name' => \Request::get('name'),
            'url' => \Request::get('url'),
            'color' => \Request::get('color')
        ]);

        return redirect(action('\App\Http\Controllers\TechnologiesController@getIndex'));
    }

    public function postEdit($technology_id)
    {
        $technology = Technologies::find($technology_id);

        $technology->name = \Request::get('name');
        $technology->url = \Request::get('url');
        $technology->color = \Request::get('color');

        $technology->save();

        return redirect(action('\App\Http\Controllers\TechnologiesController@getIndex'));
    }

    public function getEdit($technology_id)
    {
        return view('technologies.form', [
            'technology' => Technologies::find($technology_id)
        ]);
    }

    public function getDelete($technology_id)
    {
        Technologies::find($technology_id)->delete();

        return redirect(action('\App\Http\Controllers\TechnologiesController@getIndex'));
    }
}