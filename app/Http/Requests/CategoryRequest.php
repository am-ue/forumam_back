<?php

namespace App\Http\Requests;

class CategoryRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'required',
            'color' => 'required',
            'map'   => 'required|image',
        ];
    }
}
