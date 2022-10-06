<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests\AccessRequest
 *
 * @property string $name
 * @property string $comment
 */

class AccessRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1'],
            'comment' => ['string', 'nullable'],
        ];
    }
}
