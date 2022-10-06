<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\Auth\RegisterRequest
 *
 * @property string $email
 * @property string $password
 * @property string $password_confirmation
 */
class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
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
