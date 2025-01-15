<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $title = "Author";

        $authors = Author::select("id", "name", "email")->paginate(5);

        return view("Author.index", compact("title", "authors"));
    }

    public function store(StoreAuthorRequest $request)
    {
        try {
            $author = Author::create($request->validated());

            return response()->json(['success' => true, 'author' => $author]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui pengarang: ' . $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $author = Author::findOrFail($id);

        return response()->json($author);
    }

    public function update(UpdateAuthorRequest $request, $id)
    {
        $author = Author::findOrFail($id);

        if (!$author) {
            return response()->json([
                'error' => 'Pengarang tidak ditemukan.',
            ], 404);
        }

        try {
            $author->name = $request->name_edit;
            $author->email = $request->email_edit;
            $author->update();

            return response()->json(['success' => true, 'author' => $author]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui pengarang: ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        if (!$author) {
            return response()->json([
                'error' => 'Pengarang tidak ditemukan.',
            ], 404);
        }

        try {
            $author->delete();

            return response()->json(['success' => true, 'id' => $id]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui pengarang: ' . $th->getMessage()
            ], 500);
        }
    }
}
