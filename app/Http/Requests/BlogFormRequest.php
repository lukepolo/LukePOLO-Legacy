<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'draft' => 'required',
            'link_name' => 'required|unique:blogs,link_name,'.$this->blogID.',_id'
        ];
    }

    public function authorize()
    {
        return \Auth::check();
    }
}