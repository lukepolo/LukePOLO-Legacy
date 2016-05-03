<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagFormRequest extends FormRequest
{
    public function rules()
    {
        $id = null;
        if ($this->one) {
            $id = ',' . $this->one;
        }

        return [
            'name' => 'required|unique:tags' . $id,
            'color' => 'required',
        ];
    }

    public function authorize()
    {
        return \Auth::check();
    }
}