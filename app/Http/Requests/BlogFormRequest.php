<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogFormRequest extends FormRequest
{
    public function rules()
    {
        $id = null;
        if ($this->one) {
            $id = ',' . $this->one;
        }

        return [
            'name' => 'required',
            'draft' => 'required',
            'link_name' => 'required|unique:blogs' . $id
        ];
    }

    public function authorize()
    {
        return \Auth::check();
    }
}