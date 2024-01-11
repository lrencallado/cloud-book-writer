<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Book/Index', [
            'books' => $request->user()->books()->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Book/Create', [
            'genres' => Genre::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:books',
            'description' => 'required|string',
            'genres' => 'required',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $book->addCollaborator($request->user(), 'Author');

        foreach ($request->genres as $genre) {
            $book->addGenre($genre);
        }

        return Inertia::location(route('books.show', [ 'book' => $book->id ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Book $book)
    {
        if ($book->collaborators->contains($request->user())) {
            return Inertia::render('Book/Show', [
                'book' => $book,
                'sections' => $book->sections()->get()
            ]);
        }

        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
