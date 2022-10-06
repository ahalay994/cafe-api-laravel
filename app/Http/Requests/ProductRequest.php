<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\ProductRequest
 *
 * @property string $name
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string $image
 * @property bool $hidden
 * @property int $category_id
 */
class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:additions'],
            'short_description' => ['string'],
            'description' => ['string'],
            'image' => ['string'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}
