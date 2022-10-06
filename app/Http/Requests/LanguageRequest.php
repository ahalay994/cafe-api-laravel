<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\LanguageRequest
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property bool $blocked
 */

class LanguageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'key' => ['required', 'unique:languages'],
            'name' => ['required', 'unique:languages'],
            'blocked' => ['nullable'],
        ];
    }
}
