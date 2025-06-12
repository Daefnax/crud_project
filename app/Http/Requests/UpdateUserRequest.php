<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'string|max:255',
            'job_title' => 'string|max:255',
            'phone' => 'string|max:255',
            'address' => 'string|max:255',
            'vk' => 'url',
            'telegram' => 'url',
            'instagram' => 'url',
        ];
    }

    public function messages(): array
    {
        return [
            'vk.url' => 'Поле VK должно быть действительным URL.',
            'telegram.url' => 'Поле Telegram должно быть действительным URL.',
            'instagram.url' => 'Поле Instagram должно быть действительным URL.',
        ];
    }
}
