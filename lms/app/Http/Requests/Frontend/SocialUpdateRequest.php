<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SocialUpdateRequest extends FormRequest
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
            'facebook' => ['nullable', 'url', 'max:255'],
            'x' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'facebook.url' => 'Please enter a valid Facebook URL',
            'x.url' => 'Please enter a valid X (Twitter) URL',
            'linkedin.url' => 'Please enter a valid LinkedIn URL',
            'website.url' => 'Please enter a valid website URL',
            'facebook.max' => 'Facebook URL cannot be longer than 255 characters',
            'x.max' => 'X (Twitter) URL cannot be longer than 255 characters',
            'linkedin.max' => 'LinkedIn URL cannot be longer than 255 characters',
            'website.max' => 'Website URL cannot be longer than 255 characters',
        ];
    }
}
