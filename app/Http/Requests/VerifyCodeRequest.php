<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|size:6|regex:/^[0-9]{6}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode verifikasi wajib diisi.',
            'code.size' => 'Kode verifikasi harus 6 digit angka.',
            'code.regex' => 'Kode verifikasi hanya boleh berisi angka 0-9.',
        ];
    }
}
