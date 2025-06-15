<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'headline' => ['nullable', 'max:255', 'string'],
            'email' => ['required', 'max:255', 'email', 'unique:users,email,' . $this->user()->id],
            'about' => ['nullable', 'max:6000', 'string'],
            'gender' => ['nullable', 'in:male,female'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'avatar.max' => 'The image may not be greater than 2MB.',
        ];
    }
}
