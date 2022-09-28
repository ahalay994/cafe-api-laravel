<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2'],
            'slug' => ['required', 'min:2', 'unique:categories'],
            'description' => ['required', 'string'],
            'parent_id' => ['nullable', 'numeric', 'exists:categories,id'],
            'order' => ['nullable', 'numeric'],
        ];
    }
}