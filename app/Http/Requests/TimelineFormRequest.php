<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimelineFormRequest extends FormRequest
{
    public function rules()
    {
        $id = null;
        if($this->one)
        {
            $id = ','.$this->one;
        }

        return [
            'name' => 'required|unique:timelines'.$id,
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