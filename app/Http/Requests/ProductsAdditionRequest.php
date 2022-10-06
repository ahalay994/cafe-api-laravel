<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\ProductsAdditionRequest
 *
 * @property int $product_id
 * @property int $addition_id
 */

class ProductsAdditionRequest extends FormRequest
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
            'addition_id' => ['required', 'exists:additions,id'],
        ];
    }
}
