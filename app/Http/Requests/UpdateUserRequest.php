<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'max:700'],
            'url' => ['required', 'url', 'string', 'max:191'],
            'avatar' => ['image', 'mimes:jpg,jpeg,png,gif,svg', 'max:1024'],
        ];
    }
}
