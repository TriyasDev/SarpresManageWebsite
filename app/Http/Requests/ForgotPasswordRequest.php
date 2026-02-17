<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi. Silakan masukkan alamat email Anda.',
            'email.email' => 'Format email tidak valid. Contoh format yang benar: nama@domain.com',
        ];
    }
}
