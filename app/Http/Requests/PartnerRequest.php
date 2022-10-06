<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\PartnerRequest
 *
 * @property string $name
 * @property string $image
 */
class PartnerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2'],
            'slug' => ['string'],
        ];
    }
}
