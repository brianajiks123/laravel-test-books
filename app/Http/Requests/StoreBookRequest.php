<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|string',
            'serial_number' => 'required|integer|unique:books,serial_number',
            'published_at' => 'required|date',
            'author_id' => 'required|integer|exists:authors,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul buku harus diisi.',
            'title.string' => 'Judul buku harus berisi karakter.',
            'serial_number.required' => 'Nomor seri buku harus diisi.',
            'serial_number.integer' => 'Nomor seri buku harus berupa angka.',
            'serial_number.unique' => 'Nomor seri buku sudah terdaftar.',
            'published_at.required' => 'Tanggal publikasi harus diisi.',
            'published_at.date' => 'Tanggal publikasi harus berupa tanggal yang valid.',
            'author_id.required' => 'ID pengarang harus diisi.',
            'author_id.integer' => 'ID pengarang harus berupa angka.',
            'author_id.exists' => 'Pengarang yang dipilih tidak valid.',
        ];
    }
}
