<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:tags',
            'color' => 'required',
        ];
    }

    public function authorize()
    {
        return \Auth::check();
    }
}