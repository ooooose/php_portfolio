<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoardRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:30'],
            'url' => ['required', 'string'],
            'img_path' => ['required', 'image', 'max:1024', 'mimes:jpg,jpeg,png'],
            'description' => ['required', 'string', 'max:200'],
        ];
    }
}
