<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TechnologiesFormRequest extends FormRequest
{
    public function rules()
    {
        $id = null;
        if($this->one)
        {
            $id = ','.$this->one;
        }

        return [
            'name' => 'required|unique:technologies'.$id,
            'color' => 'required',
            'url' => 'required'
        ];
    }

    public function authorize()
    {
        return \Auth::check();
    }
}