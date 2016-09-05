<?php


namespace App\Http\Requests;

class OptionRelationRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parent_id'  => 'required|exists:option_details,id',
            'child_id'  => 'required|exists:option_details,id|different:parent_id',
            'parent_value' => 'required',
            'child_value' => 'required',
        ];
    }
}
