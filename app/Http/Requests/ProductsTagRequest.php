<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\ProductsTagRequest
 *
 * @property int $product_id
 * @property int $tag_id
 */
class ProductsTagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'tag_id' => ['required', 'exists:tags,id'],
        ];
    }
}
