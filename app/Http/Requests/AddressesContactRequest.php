<?php

namespace App\Http\Requests;

use App\Enum\AddressesContactTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * App\Http\Requests\AddressesContactRequest
 *
 * @property int $address_id
 * @property string $type
 * @property string $value
 * @property string $description
 */
class AddressesContactRequest extends FormRequest
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
            'type' => ['required', new Enum(AddressesContactTypesEnum::class)],
            'value' => ['required'],
            'description' => ['string', 'nullable']
        ];
    }
}
