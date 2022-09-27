<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersContactRequest extends FormRequest
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
            'phone' => ['regex:/^([0-9\s\+]*)$/'],
            'first_name' => ['string', 'nullable'],
            'last_name' => ['string', 'nullable'],
            'patronymic_name' => ['string', 'nullable'],
            'date_birthday' => ['date', 'nullable'],
        ];
    }
}
