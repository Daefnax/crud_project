<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'username' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'vk' => 'nullable|url',
            'telegram' => 'nullable|url',
            'instagram' => 'nullable|url',
            'status' => 'nullable|in:online,away,do_not_disturb',
            'role' => 'nullable|in:user,admin',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.email' => 'Поле Email должно быть действительным адресом электронной почты.',
            'email.unique' => 'Такой Email уже используется.',

            'password.required' => 'Поле Пароль обязательно для заполнения.',
            'password.min' => 'Пароль должен содержать минимум :min символов.',

            'username.string' => 'Имя пользователя должно быть строкой.',
            'username.max' => 'Имя пользователя не должно превышать :max символов.',

            'job_title.string' => 'Должность должна быть строкой.',
            'job_title.max' => 'Должность не должна превышать :max символов.',

            'phone.string' => 'Телефон должен быть строкой.',
            'phone.max' => 'Телефон не должен превышать :max символов.',

            'address.string' => 'Адрес должен быть строкой.',

            'vk.url' => 'Поле VK должно быть действительным URL.',
            'telegram.url' => 'Поле Telegram должно быть действительным URL.',
            'instagram.url' => 'Поле Instagram должно быть действительным URL.',

            'image.image' => 'Файл должен быть изображением.',
            'image.mimes' => 'Допустимые форматы изображения: jpeg, png, jpg, gif.',
            'image.max' => 'Максимальный размер изображения: 2MB.',
        ];
    }

}
