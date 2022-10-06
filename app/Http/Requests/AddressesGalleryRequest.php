<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\AddressesGalleryRequest
 *
 * @property int $address_id
 * @property string $image
 * @property int $sort
 */
class AddressesGalleryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'address_id' => ['required', 'exists:addresses,id'],
            'image' => ['required'],
            'sort' => ['required'],
        ];
    }
}
