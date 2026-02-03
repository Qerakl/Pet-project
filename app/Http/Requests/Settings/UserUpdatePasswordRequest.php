<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdatePasswordRequest extends FormRequest
{
    protected $redirectRoute = 'view.settings';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ];
    }
    public function messages(): array
    {
        return [
            'current_password.required' => 'Введите текущий пароль.',
            'current_password.current_password' => 'Текущий пароль указан неверно.',

            'new_password.required' => 'Введите новый пароль.',
            'new_password.min' => 'Новый пароль должен быть не менее 8 символов.',
            'new_password.confirmed' => 'Пароли не совпадают.',
            'new_password.different' => 'Новый пароль должен отличаться от текущего.',
        ];
    }

}
