<?php

namespace App\Http\Requests;

class PostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'        => 'required|in:article,video',
            'title'       => 'required',
            'description' => 'required',
            'youtube_id'  => 'required_if:type,video',
            'img'         => 'required_if:type,article|image',
        ];
    }
}
