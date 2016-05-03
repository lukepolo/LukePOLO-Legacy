<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFormRequest extends FormRequest
{
    public function rules()
    {
        $id = null;
        if ($this->one) {
            $id = ',' . $this->one;
        }

        return [
            'name' => 'required|unique:projects' . $id,
            'start_date' => 'required',
            'end_date' => 'required',
            'project_image' => 'required',
        ];
    }

    public function authorize()
    {
        return \Auth::check();
    }
}