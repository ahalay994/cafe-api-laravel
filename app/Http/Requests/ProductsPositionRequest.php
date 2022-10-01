<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
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
            'product_id' => ['required', 'exists:products,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'image' => ['string', 'nullable'],
            'price' => ['filled'],
            'discount' => ['filled'],
        ];
    }
}
