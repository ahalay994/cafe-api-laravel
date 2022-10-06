<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\RoleRequest
 *
 * @property string $name
 * @property string $slug
 */

class RoleRequest extends FormRequest
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
            'slug' => ['required', 'string', 'min:2'],
        ];
    }
}
