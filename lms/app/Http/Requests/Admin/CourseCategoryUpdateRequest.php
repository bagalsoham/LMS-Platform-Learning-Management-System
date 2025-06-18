<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseCategoryUpdateRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'max:3000'],
            'name' => ['required', 'string', 'max:255', 'unique:course_categories,name,'.$this->course_category->id],
            'icon' => ['required', 'string', 'max:255'],
            'show_at_trending' => ['nullable', 'boolean'],
            'status' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'image.required' => 'Please upload a category image.',
            'image.image' => 'The uploaded file must be an image.',
            'image.max' => 'The image size must not exceed 3MB.',
            'name.required' => 'Category name is required.',
            'name.unique' => 'This category name already exists.',
            'icon.required' => 'Icon field is required.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'show_at_trending' => 'trending display',
            'status' => 'category status',
        ];
    }
}
