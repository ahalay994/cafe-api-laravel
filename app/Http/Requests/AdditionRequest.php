<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\AdditionRequest
 *
 * @property int $name
 * @property string $slug
 * @property string $description
 * @property string $image
 * @property double $price
 * @property int $discount
 */
class AdditionRequest extends FormRequest
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
            'description' => ['string'],
            'image' => ['string'],
            'price' => ['required'],
            'discount' => ['required', 'numeric'],
        ];
    }
}
