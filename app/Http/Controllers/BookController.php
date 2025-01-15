<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $title = "Book";

        $authors = Author::select("id", "name")->get();
        $books = Book::select("id", "title", "serial_number", "published_at", "author_id")
            ->with('author')
            ->paginate(5);

        return view("Book.index", compact("title", "authors", "books"));
    }

    public function store(StoreBookRequest $request)
    {
        try {
            $book = Book::create($request->validated());
            $book->load('author');

            return response()->json(['success' => true, 'book' => $book]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui buku: ' . $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);

        return response()->json($book);
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);

        if (!$book) {
            return response()->json([
                'error' => 'Buku tidak ditemukan.',
            ], 404);
        }

        try {
            $book->title = $request->title_edit;
            $book->serial_number = $request->serial_number_edit;
            $book->published_at = $request->published_at_edit;
            $book->author_id = $request->author_id_edit;
            $book->update();

            return response()->json(['success' => true, 'book' => $book]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui buku: ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if (!$book) {
            return response()->json([
                'error' => 'Buku tidak ditemukan.',
            ], 404);
        }

        try {
            $book->delete();

            return response()->json(['success' => true, 'id' => $id]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui buku: ' . $th->getMessage()
            ], 500);
        }
    }
}
