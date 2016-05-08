<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFormRequest extends FormRequest
{
    public function rules()
    {

        $rules = [
            'name' => 'required|unique:projects,' . $this->projectID,
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        if(empty($this->projectID)) {
            $rules['project_image'] = 'required|image';
        }

        return $rules;
    }

    public function authorize()
    {
        return \Auth::check();
    }
}