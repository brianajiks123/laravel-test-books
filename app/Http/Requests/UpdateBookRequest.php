<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'id' => 'required|integer|exists:books,id',
            'title_edit' => 'required|string',
            'serial_number_edit' => 'required|integer|unique:books,serial_number,' . $this->id,
            'published_at_edit' => 'required|date',
            'author_id_edit' => 'required|integer|exists:authors,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'ID pengarang harus diisi.',
            'id.integer' => 'ID pengarang harus berupa angka.',
            'id.exists' => 'Buku yang dipilih tidak valid.',
            'title_edit.required' => 'Judul buku harus diisi.',
            'title_edit.string' => 'Judul buku harus berisi karakter.',
            'serial_number.required' => 'Nomor seri buku harus diisi.',
            'serial_number_edit.integer' => 'Nomor seri buku harus berupa angka.',
            'serial_number_edit.unique' => 'Nomor seri buku sudah terdaftar.',
            'published_at_edit.required' => 'Tanggal publikasi harus diisi.',
            'published_at_edit.date' => 'Tanggal publikasi harus berupa tanggal yang valid.',
            'author_id_edit.required' => 'ID pengarang harus diisi.',
            'author_id_edit.integer' => 'ID pengarang harus berupa angka.',
            'author_id_edit.exists' => 'Pengarang yang dipilih tidak valid.',
        ];
    }
}
