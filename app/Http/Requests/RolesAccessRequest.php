<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\RolesAccessRequest
 *
 * @property int $role_id
 * @property int $access_id
 */

class RolesAccessRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'role_id' => ['required', 'exists:roles,id'],
            'access_id' => ['required', 'exists:accesses,id'],
        ];
    }
}
