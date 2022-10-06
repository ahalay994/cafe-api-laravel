<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\AddressRequest
 *
 * @property string $name
 * @property string $description
 * @property double $lat
 * @property double $lon
 */
class AddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['string'],
            'lat' => ['required'],
            'lon' => ['required'],
        ];
    }
}
