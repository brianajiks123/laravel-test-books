@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="mb-4">
            <button class="btn bg-blue-800 text-white py-2 px-4 rounded-md hover:bg-blue-700" id="modal_open">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>

        {{-- Modal: Add Author --}}
        <div id="modal_add" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4" id="add_modal_title">Tambah Pengarang</h2>

                <form id="add_author_form">
                    <div class="mb-4">
                        <label for="name_add" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="name_add" name="name"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                        <small id="name_add_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="mb-4">
                        <label for="email_add" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email_add" name="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                        <small id="email_add_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="button" id="modal_close_add"
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">Tutup</button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700"
                            id="add_submit_btn">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal: Edit Author --}}
        <div id="modal_edit" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4" id="edit_modal_title">Edit Pengarang</h2>

                <form id="edit_author_form">
                    <input type="hidden" id="author_id_edit" name="id">
                    <div class="mb-4">
                        <label for="name_edit" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="name_edit" name="name_edit"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                        <small id="name_edit_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="mb-4">
                        <label for="email_edit" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email_edit" name="email_edit"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                        <small id="email_edit_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="button" id="modal_close_edit"
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">Tutup</button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700"
                            id="edit_submit_btn">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="success_msg" class="bg-green-500 text-white p-4 mb-4 rounded-md hidden"></div>
        <div id="error_msg" class="bg-red-500 text-white p-4 mb-4 rounded-md hidden"></div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-center border-collapse shadow-md rounded-lg overflow-hidden"
                id="author_table">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2 font-semibold text-gray-700">#</th>
                        <th class="border px-4 py-2 font-semibold text-gray-700">Nama</th>
                        <th class="border px-4 py-2 font-semibold text-gray-700">Email</th>
                        <th class="border px-4 py-2 font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($authors as $key => $author)
                        <tr class="hover:bg-gray-50" id="author-{{ $author->id }}">
                            <td class="border px-4 py-2">
                                {{ $key + 1 + ($authors->currentPage() - 1) * $authors->perPage() }}</td>
                            <td class="border px-4 py-2">{{ $author->name }}</td>
                            <td class="border px-4 py-2">{{ $author->email }}</td>
                            <td
                                class="border px-4 py-2 space-x-2 flex justify-center flex-wrap space-y-2 sm:space-y-0 sm:flex-row">
                                <button
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300 w-full sm:w-auto"
                                    id="edit_author_btn" data-id="{{ $author->id }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button
                                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300 w-full sm:w-auto"
                                    id="delete_author_btn" data-id="{{ $author->id }}"
                                    data-url="{{ route('authors.destroy', $author->id) }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center italic">Data pengarang kosong!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $authors->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openModalButton = document.getElementById('modal_open');
        const closeAddModalButton = document.getElementById('modal_close_add');
        const closeEditModalButton = document.getElementById('modal_close_edit');

        const addModal = document.getElementById('modal_add');
        const editModal = document.getElementById('modal_edit');
        const addAuthorForm = $('#add_author_form');
        const editAuthorForm = $('#edit_author_form');

        const addSubmitButton = $('#add_submit_btn');
        const editSubmitButton = $('#edit_submit_btn');

        const addNameError = $('#name_add_error');
        const addEmailError = $('#email_add_error');

        const editNameError = $('#name_edit_error');
        const editEmailError = $('#email_edit_error');

        const successMessage = $('#success_msg');
        const errorMessage = $('#error_msg');

        // Open Add Modal
        openModalButton.addEventListener('click', () => {
            addModal.classList.remove('hidden');
            addModal.classList.add('flex');
        });

        // Close Add Modal
        closeAddModalButton.addEventListener('click', () => {
            addModal.classList.add('hidden');
            addModal.classList.remove('flex');
        });

        // Close Edit Modal
        closeEditModalButton.addEventListener('click', () => {
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
        });

        // Hide modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === addModal) {
                addModal.classList.add('hidden');
                addModal.classList.remove('flex');
            }
            if (e.target === editModal) {
                editModal.classList.add('hidden');
                editModal.classList.remove('flex');
            }
        });

        // Set CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add
        addAuthorForm.submit(function(e) {
            e.preventDefault();

            // Hide errors and messages
            addNameError.addClass('hidden');
            addEmailError.addClass('hidden');
            successMessage.addClass('hidden');
            errorMessage.addClass('hidden');

            const formData = new FormData(addAuthorForm[0]);

            // console.log('Data yang akan dikirim untuk diupdate:');
            // for (let [key, value] of formData.entries()) {
            //     console.log(key + ': ' + value);
            // }

            $.ajax({
                url: "{{ route('authors.store') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        addAuthorForm[0].reset();

                        const emptyRow = $('#author_table tbody tr:contains("Data pengarang kosong!")');

                        if (emptyRow.length > 0) {
                            emptyRow.remove();
                        }

                        const newRow = `
                            <tr class="hover:bg-gray-50" id="author-${response.author.id}">
                                <td class="border px-4 py-2">${response.author.id}</td>
                                <td class="border px-4 py-2">${response.author.name}</td>
                                <td class="border px-4 py-2">${response.author.email}</td>
                                <td class="border px-4 py-2 space-x-2 flex justify-center flex-wrap space-y-2 sm:space-y-0 sm:flex-row">
                                    <button
                                        class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300 w-full sm:w-auto"
                                        id="edit_author_btn" data-id="${response.author.id}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                    <button
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300 w-full sm:w-auto"
                                        id="delete_author_btn" data-id="${response.author.id}"
                                        data-url="{{ url('authors') }}/${response.author.id}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;

                        $('#author_table tbody').append(newRow);

                        successMessage.text('Pengarang berhasil ditambahkan').removeClass('hidden');

                        setTimeout(function() {
                            successMessage.addClass('hidden');
                        }, 3000);

                        addModal.classList.add('hidden');
                    }
                },
                error: function(response) {
                    const errors = response.responseJSON.errors;

                    if (errors.name) {
                        addNameError.text(errors.name[0]).removeClass('hidden');
                    }

                    if (errors.email) {
                        addEmailError.text(errors.email[0]).removeClass('hidden');
                    }

                    if (response.responseJSON.error) {
                        errorMessage.text(response.responseJSON.error).removeClass('hidden');
                    }
                }
            });
        });

        // Edit
        $('#author_table').on('click', '[data-id]:has(i.fa-pencil)', function(e) {
            const authorId = $(this).data('id');

            fetch(`/authors/${authorId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name_edit').value = data.name;
                    document.getElementById('email_edit').value = data.email;
                    document.getElementById('author_id_edit').value = data.id;

                    document.getElementById('modal_edit').classList.remove('hidden');
                    editSubmitButton.text('Update');
                    editModal.classList.remove('hidden');
                    editModal.classList.add('flex');
                })
                .catch(error => {
                    console.error('Error fetching author data:', error);
                });
        });

        // Update
        editAuthorForm.on('submit', function(e) {
            e.preventDefault();

            const formData = editAuthorForm.serialize();

            $.ajax({
                url: `/authors/${$('#author_id_edit').val()}`,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        const updatedRow = document.querySelector(`#author-${response.author.id}`);

                        if (updatedRow) {
                            updatedRow.querySelector('td:nth-child(2)').textContent = response.author.name;
                            updatedRow.querySelector('td:nth-child(3)').textContent = response.author.email;
                        }

                        successMessage.text('Pengarang berhasil diperbarui').removeClass('hidden');

                        setTimeout(function() {
                            successMessage.addClass('hidden');
                        }, 3000);

                        editModal.classList.add('hidden');
                    }
                },
                error: function(response) {
                    const errors = response.responseJSON.errors;

                    if (errors.name) {
                        addNameError.text(errors.name[0]).removeClass('hidden');
                    }

                    if (errors.email) {
                        addEmailError.text(errors.email[0]).removeClass('hidden');
                    }

                    if (response.responseJSON.error) {
                        errorMessage.text(response.responseJSON.error).removeClass('hidden');
                    }
                }
            });
        });

        // Delete
        $('#author_table').on('click', '[data-id]:has(i.fa-trash)', function(event) {
            const authorId = $(this).data('id');
            const url = $(this).data('url');

            if (confirm('Yakin menghapus pengarang ini?')) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const authorRow = document.querySelector(`#author-${authorId}`);

                        if (authorRow) {
                            authorRow.remove();
                        }

                        const remainingRows = document.querySelectorAll('#author_table tbody tr');

                        alert('Pengarang berhasil dihapus');
                    } else {
                        alert('Gagal menghapus pengarang');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus pengarang');
                });
            }
        });
    });
</script>
