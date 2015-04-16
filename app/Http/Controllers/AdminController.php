<?php
/**
 * Created by PhpStorm.
 * User: LukePOLO
 * Date: 4/7/15
 * Time: 1:30 PM
 */

namespace App\Http\Controllers;

use App\Models\Mongo\Timeline;

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

    public function postCreate()
    {
        $timeline = Timeline::create([
            'type' => \Request::get('type'),
            'name' => \Request::get('name'),
            'start_date' => \Request::get('start_date'),
            'end_date' => \Request::get('end_date'),
            'description' => \Request::get('description')
        ]);

        $timeline->save();
    }
}