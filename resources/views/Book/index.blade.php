@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="mb-4">
            <button class="btn bg-blue-800 text-white py-2 px-4 rounded-md hover:bg-blue-700" id="modal_open">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>

        {{-- Modal: Add Book --}}
        <div id="modal_add" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4" id="add_modal_title">Tambah Buku</h2>

                <form id="add_book_form">
                    <div class="mb-4">
                        <label for="title_add" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" id="title_add" name="title"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                        <small id="title_add_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="mb-4">
                        <label for="serial_number_add" class="block text-sm font-medium text-gray-700">No. Seri</label>
                        <input type="number" id="serial_number_add" name="serial_number"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" min="1" autocomplete="true">
                        <small id="serial_number_add_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="mb-4">
                        <label for="publish_add" class="block text-sm font-medium text-gray-700">Tanngal Publish</label>
                        <input type="date" id="publish_add" name="published_at"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                        <small id="publish_add_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="mb-4">
                        <label for="author" class="block text-sm font-medium text-gray-700">Pengarang</label>
                        <select name="author_id" id="author" class="w-full px-3 py-2 border border-gray-300 rounded mt-1"
                            autocomplete="true">
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
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

        {{-- Modal: Edit Book --}}
        <div id="modal_edit" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4" id="edit_modal_title">Edit Buku</h2>

                <form id="edit_book_form">
                    <input type="hidden" id="book_id_edit" name="id">
                    <div class="mb-4">
                        <label for="title_edit" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" id="title_edit" name="title_edit"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                        <small id="title_edit_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="mb-4">
                        <label for="serial_number_edit" class="block text-sm font-medium text-gray-700">No. Seri</label>
                        <input type="number" id="serial_number_edit" name="serial_number_edit"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" min="1" readonly>
                        <small id="serial_number_edit_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="mb-4">
                        <label for="publish_edit" class="block text-sm font-medium text-gray-700">Tanngal Publish</label>
                        <input type="date" id="publish_edit" name="published_at_edit"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                        <small id="publish_edit_error" class="text-red-500 hidden"></small>
                    </div>

                    <div class="mb-4">
                        <label for="author_edit" class="block text-sm font-medium text-gray-700">Pengarang</label>
                        <select name="author_id_edit" id="author_edit"
                            class="w-full px-3 py-2 border border-gray-300 rounded mt-1" autocomplete="true">
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
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
                id="book_table">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2 font-semibold text-gray-700">#</th>
                        <th class="border px-4 py-2 font-semibold text-gray-700">Judul</th>
                        <th class="border px-4 py-2 font-semibold text-gray-700">No. Seri</th>
                        <th class="border px-4 py-2 font-semibold text-gray-700">Publish</th>
                        <th class="border px-4 py-2 font-semibold text-gray-700">Pengarang</th>
                        <th class="border px-4 py-2 font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $key => $book)
                        <tr class="hover:bg-gray-50" id="book-{{ $book->id }}">
                            <td class="border px-4 py-2">
                                {{ $key + 1 + ($books->currentPage() - 1) * $books->perPage() }}</td>
                            <td class="border px-4 py-2">{{ $book->title }}</td>
                            <td class="border px-4 py-2">{{ $book->serial_number }}</td>
                            <td class="border px-4 py-2">{{ $book->published_at }}</td>
                            <td class="border px-4 py-2">{{ $book->author->name }}</td>
                            <td
                                class="border px-4 py-2 space-x-2 flex justify-center flex-wrap space-y-2 sm:space-y-0 sm:flex-row">
                                <button
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300 w-full sm:w-auto"
                                    id="edit_book_btn" data-id="{{ $book->id }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button
                                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300 w-full sm:w-auto"
                                    id="delete_book_btn" data-id="{{ $book->id }}"
                                    data-url="{{ route('books.destroy', $book->id) }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $books->links('vendor.pagination.tailwind') }}
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
        const addBookForm = $('#add_book_form');
        const editBookForm = $('#edit_book_form');

        const addSubmitButton = $('#add_submit_btn');
        const editSubmitButton = $('#edit_submit_btn');
        const editBookButtons = document.querySelectorAll('#edit_book_btn');
        const deleteBookButtons = document.querySelectorAll('#delete_book_btn');

        const addTitleError = $('#title_add_error');
        const addSNError = $('#serial_number_add_error');
        const addPublishError = $('#publish_add_error');
        const addAuthorError = $('#author_add_error');

        const editTitleError = $('#titleedit_error');
        const editSNError = $('#serial_number_edit_error');
        const editPublishError = $('#publish_edit_error');
        const editAuthorError = $('#author_edit_error');

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
        addBookForm.submit(function(e) {
            e.preventDefault();

            // Hide errors and messages
            addTitleError.addClass('hidden');
            addSNError.addClass('hidden');
            addPublishError.addClass('hidden');
            addAuthorError.addClass('hidden');
            successMessage.addClass('hidden');
            errorMessage.addClass('hidden');

            const formData = new FormData(addBookForm[0]);

            // console.log('Data yang akan dikirim untuk diupdate:');
            // for (let [key, value] of formData.entries()) {
            //     console.log(key + ': ' + value);
            // }

            $.ajax({
                url: "{{ route('books.store') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        const newRow = `
                            <tr class="hover:bg-gray-50" id="book-${response.book.id}">
                                <td class="border px-4 py-2">${response.book.id}</td>
                                <td class="border px-4 py-2">${response.book.title}</td>
                                <td class="border px-4 py-2">${response.book.serial_number}</td>
                                <td class="border px-4 py-2">${response.book.published_at}</td>
                                <td class="border px-4 py-2">${response.book.author ? response.book.author.name : 'Unknown'}</td>
                                <td class="border px-4 py-2 space-x-2 flex justify-center flex-wrap space-y-2 sm:space-y-0 sm:flex-row">
                                    <button
                                        class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300 w-full sm:w-auto"
                                        id="edit_book_btn" data-id="${response.book.id}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                    <button
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300 w-full sm:w-auto"
                                        id="delete_book_btn" data-id="${response.book.id}"
                                        data-url="{{ url('books') }}/${response.book.id}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;

                        $('#book_table tbody').append(
                            newRow);

                        successMessage.text('Buku berhasil ditambahkan').removeClass(
                            'hidden');

                        setTimeout(function() {
                            successMessage.addClass('hidden');
                        }, 3000);

                        addModal.classList.add('hidden');
                    }
                },
                error: function(response) {
                    const errors = response.responseJSON.errors;

                    if (errors.name) {
                        addTitleError.text(errors.name[0]).removeClass('hidden');
                    }

                    if (errors.email) {
                        addSNError.text(errors.email[0]).removeClass('hidden');
                    }

                    if (response.responseJSON.error) {
                        errorMessage.text(response.responseJSON.error).removeClass(
                            'hidden');
                    }
                }
            });
        });

        // Edit
        editBookButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const bookId = this.getAttribute('data-id');

                fetch(`/books/${bookId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('title_edit').value = data.title;
                        document.getElementById('serial_number_edit').value = data
                            .serial_number;
                        document.getElementById('publish_edit').value = data.published_at;
                        document.getElementById('book_id_edit').value = data.id;

                        const authorSelect = document.getElementById('author_edit');
                        for (let option of authorSelect.options) {
                            if (option.value == data.author_id) {
                                option.selected = true;
                            }
                        }

                        document.getElementById('modal_edit').classList.remove('hidden');

                        editSubmitButton.text('Update');
                        editModal.classList.remove('hidden');
                        editModal.classList.add('flex');
                    })
                    .catch(error => {
                        console.error('Error fetching book data:', error);
                    });
            });
        });

        // Update
        editBookForm.on('submit', function(e) {
            e.preventDefault();

            const formData = editBookForm.serialize();

            $.ajax({
                url: `/books/${$('#book_id_edit').val()}`,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        const updatedRow = document.querySelector(
                            `#book-${response.book.id}`);

                        if (updatedRow) {
                            updatedRow.querySelector('td:nth-child(2)').textContent =
                                response.book.title;
                            updatedRow.querySelector('td:nth-child(3)').textContent =
                                response.book.serial_number;
                            updatedRow.querySelector('td:nth-child(4)').textContent =
                                response.book.published_at;
                            updatedRow.querySelector('td:nth-child(5)').textContent =
                                response.book.author ? response.book.author.name :
                                'Unknown';
                        }

                        successMessage.text('Buku berhasil diperbarui').removeClass(
                            'hidden');

                        setTimeout(function() {
                            successMessage.addClass('hidden');
                        }, 3000);

                        editModal.classList.add('hidden');
                    }
                },
                error: function(response) {
                    const errors = response.responseJSON.errors;

                    if (errors.name) {
                        addTitleError.text(errors.name[0]).removeClass('hidden');
                    }

                    if (errors.email) {
                        addSNError.text(errors.email[0]).removeClass('hidden');
                    }

                    if (response.responseJSON.error) {
                        errorMessage.text(response.responseJSON.error).removeClass(
                            'hidden');
                    }
                }
            });
        });

        // Delete
        deleteBookButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                const bookId = this.getAttribute('data-id');
                const url = this.getAttribute('data-url');

                if (confirm('Yakin menghapus buku ini?')) {
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const bookRow = document.querySelector(
                                    `#book-${bookId}`);
                                if (bookRow) {
                                    bookRow.remove();
                                }
                                alert('Buku berhasil dihapus');
                            } else {
                                alert('Gagal menghapus buku');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menghapus buku');
                        });
                }
            });
        });
    });
</script>
