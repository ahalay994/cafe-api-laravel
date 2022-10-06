<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\Auth\LoginRequest
 *
 * @property string $email
 * @property string $password
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns', 'exists:users,email'],
            'password' => ['required', 'min:8'],
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
                'exists' => 'Пользователь не зарегистрирован',
            ],
            'password' => [
                'required' => 'Поле "Пароль" обязательно к заполнению',
                'min' => 'Пароль должен состоять минимум из 8 символов',
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
