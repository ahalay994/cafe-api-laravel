<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\CategoryRequest
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $parent_id
 * @property int $order
 */
class CategoryRequest extends FormRequest
{
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
