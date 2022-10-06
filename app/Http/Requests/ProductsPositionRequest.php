<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\ProductsPositionRequest
 *
 * @property int $id
 * @property int $product_id
 * @property int $position_id
 * @property string $image
 * @property float $price
 * @property int $discount
 */

class ProductsPositionRequest extends FormRequest
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
            'position_id' => ['required', 'exists:positions,id'],
            'image' => ['string', 'nullable'],
            'price' => ['filled'],
            'discount' => ['filled'],
        ];
    }
}
