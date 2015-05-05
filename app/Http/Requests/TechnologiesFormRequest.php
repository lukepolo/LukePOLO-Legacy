<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TechnologiesFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:technologies',
            'color' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ];
    }

    public function authorize()
    {
        return \Auth::check();
    }
}