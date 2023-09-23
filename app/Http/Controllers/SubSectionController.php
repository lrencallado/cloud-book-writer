<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Section;
use App\Models\SubSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubSectionController extends Controller
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
    public function store(Request $request, Book $book, Section $section)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:sub_sections'
        ]);

        SubSection::create([
            'title' => $request->title,
            'section_id' => $section->id
        ]);

        return Inertia::render('Book/Section/Edit', [
            'book' => $book,
            'sections' => $book->sections()->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubSection $subSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book, Section $section, SubSection $subSection)
    {
        return Inertia::render('Book/Section/Subsection/Edit', [
            'book' => $book,
            'sections' => $book->sections()->get(),
            'current_subsection' => $subSection
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubSection $subSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubSection $subSection)
    {
        //
    }
}
