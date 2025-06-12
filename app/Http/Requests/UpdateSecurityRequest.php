<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSecurityRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $userId = $this->input('user_id', auth()->id());

        return [
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'password' => ['required', 'min:6'],
        ];
    }
}
