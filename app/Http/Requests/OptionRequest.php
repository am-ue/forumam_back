<?php


namespace App\Http\Requests;

class OptionRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $except = $this->route('option') ? ', ' . $this->route('option')->id : '';
        return [
            'name'  => 'required | unique:options,name' . $except,
            'type' => 'required',
            'label' => 'required_if:type,select',
            'price' => 'required'
        ];
    }
}
