<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the users is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле Email обязательно.',
            'email.email' => 'Введите корректный Email.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'email.unique' => 'Такой Email уже зарегистрирован.',

            'password.required' => 'Поле Пароль обязательно.',
            'password.min' => 'Пароль должен быть не менее :min символов.',
        ];
    }
}
