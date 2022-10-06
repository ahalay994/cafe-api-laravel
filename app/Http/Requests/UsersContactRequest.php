<?php

namespace App\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\UsersContactRequest
 *
 * @property string|null $phone
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $patronymic_name
 * @property Carbon|null $date_birthday
 */

class UsersContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone' => ['regex:/^([0-9\s\+]*)$/'],
            'first_name' => ['string', 'nullable'],
            'last_name' => ['string', 'nullable'],
            'patronymic_name' => ['string', 'nullable'],
            'date_birthday' => ['date', 'nullable'],
        ];
    }
}
