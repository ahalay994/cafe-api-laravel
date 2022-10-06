<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\UserRequest
 *
 * @property string $email
 * @property string $password
 * @property string $password_confirmation
 * @property bool $blocked
 */

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['filled', 'email:rfc,dns', 'unique:users'],
            'password' => ['filled', 'min:8', 'confirmed'],
            'password_confirmation' => ['filled'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'email' => [
                'required' => 'Поле "Email" обязательно к заполнению',
                'email' => 'Некорректный email',
                'unique' => 'Данная электронная почта занята',
            ],
            'password' => [
                'required' => 'Поле "Пароль" обязательно к заполнению',
                'min' => 'Пароль должен состоять минимум из 8 символов',
                'confirmed' => 'Пароли не совпадают',
            ],
            'password_confirmation' => [
                'required' => 'Поле "Подтверждение пароля" обязательно к заполнению'
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'password_confirmation' => 'Подтверждение пароля',
        ];
    }
}
