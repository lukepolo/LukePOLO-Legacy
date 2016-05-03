<?php


namespace App\Http\Controllers;

use App\Http\Requests\TechnologiesFormRequest;
use App\Models\Mongo\Technology;

/**
 * Class TechnologiesController
 * @package App\Http\Controllers
 */
class TechnologiesController extends Controller
{
    /**
     * Main technologies page
     * @return mixed
     */
    public function getIndex()
    {
        return view('technologies', [
            'technologies' => Technology::get()
        ]);
    }

    /**
     * The create form
     * @return mixed
     */
    public function getCreate()
    {
        return view('technologies.form');
    }

    /**
     * Creates a technology
     * @param TechnologiesFormRequest $request
     * @return mixed
     */
    public function postCreate(TechnologiesFormRequest $request)
    {
        Technology::create(\Request::except('_token'));

        return redirect(action('\App\Http\Controllers\TechnologiesController@getIndex'));
    }

    /**
     * The edit form
     * @param $technologyID
     * @return mixed
     */
    public function getEdit($technologyID)
    {
        return view('technologies.form', [
            'technology' => Technology::find($technologyID)
        ]);
    }

    /**
     * Updates a technology
     * @param $technologyID
     * @param TechnologiesFormRequest $request
     * @return mixed
     */
    public function postEdit($technologyID, TechnologiesFormRequest $request)
    {
        $technology = Technology::find($technologyID);
        $technology->fill(\Request::except('_token'));
        $technology->save();

        return redirect(action('\App\Http\Controllers\TechnologiesController@getIndex'));
    }

    /**
     * Deletes a technology
     * @param $technologyID
     * @return mixed
     */
    public function getDelete($technologyID)
    {
        Technology::find($technologyID)->delete();

        return redirect(action('\App\Http\Controllers\TechnologiesController@getIndex'));
    }
}