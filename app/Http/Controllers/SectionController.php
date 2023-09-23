<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:sections',
        ]);

        Section::create([
            'title' => $request->title,
            'book_id' => $book->id,
        ]);

        return Inertia::render('Book/Show', [
            'book' => $book,
            'sections' => $book->sections()->get()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book, Section $section)
    {
        return Inertia::render('Book/Section/Edit', [
            'book' => $book,
            'sections' => $book->sections()->get(),
            'current_section' => $section
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book, Section $section)
    {
        $request->validate([
            'content' => 'string'
        ]);

        $section->content = $request->content;
        $section->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
