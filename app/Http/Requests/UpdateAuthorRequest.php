<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
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
        $authorId = $this->route('id');

        return [
            'name_edit' => 'required|string|min:3',
            'email_edit' => 'required|email|unique:authors,email,' . $authorId,
        ];
    }

    public function messages()
    {
        return [
            'name_edit.required' => 'Nama pengarang harus diisi.',
            'name_edit.string' => 'Nama pengarang harus berisi karakter.',
            'name_edit.min' => 'Nama pengarang harus terdiri dari minimal 3 karakter.',
            'email_edit.required' => 'Email pengarang harus diisi.',
            'email_edit.email' => 'Format email tidak valid.',
            'email_edit.unique' => 'Email pengarang sudah terdaftar.',
        ];
    }
}
