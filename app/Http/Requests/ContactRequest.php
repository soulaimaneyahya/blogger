<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'subject' => ['bail', 'required', 'max:191'],
            'content' => ['required', 'max:500'],
            'image' => ['image', 'mimes:jpg,jpeg,png,gif,svg', 'max:1024'],
            // dimensions:min_height=500
        ];
    }
}
