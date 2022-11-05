<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['bail', 'required', 'min:5','max:191'],
            'content' => ['required', 'min:10','max:500'],
            'image' => ['image', 'mimes:jpg,jpeg,png,gif,svg', 'max:1024'],
        ];
    }
}
