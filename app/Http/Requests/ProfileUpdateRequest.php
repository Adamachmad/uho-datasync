<?php

namespace App\Http\Requests;

use App\Models\Pengaju;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('pengaju')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pengaju = auth()->guard('pengaju')->user();

        return [
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:50'],
            'no_hp' => ['required', 'max:15', 'regex:/^(\+62|62|0)\d{9,12}$/'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:100',
                Rule::unique(Pengaju::class, 'email')->ignore($pengaju?->id),
            ],
        ];
    }
}
