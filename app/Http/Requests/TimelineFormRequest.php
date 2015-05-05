<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimelineFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:timelines',
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