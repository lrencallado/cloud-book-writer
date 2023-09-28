<?php

namespace App\Http\Controllers;

use App\Events\SubsectionContentUpdated;
use App\Models\Book;
use App\Models\Section;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubsectionController extends Controller
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
        if ($book->isCollaborator($request->user())) {
            abort(401);
        }

        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        if ($request->parent_subsection_id) {
            $parentSubsection = Subsection::findOrFail($request->parent_subsection_id);

            // Create a new child subsection
            $childSubsection = new Subsection(['title' => $request->title, 'section_id' => $section->id]);
            // Associate the child subsection with its parent
            $childSubsection->parentSubsection()->associate($parentSubsection->id);

            $childSubsection->save();
        } else {
            Subsection::create([
                'title' => $request->title,
                'section_id' => $section->id
            ]);
        }

        return;
    }

    /**
     * Display the specified resource.
     */
    public function show(Subsection $subSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book, Section $section, Subsection $subsection)
    {
        return Inertia::render('Book/Section/Subsection/Edit', [
            'book' => $book,
            'sections' => $book->sections()->get(),
            'current_section' => $section,
            'current_subsection' => $subsection
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book, Section $section, Subsection $subsection)
    {
        $request->validate([
            'content' => 'string'
        ]);

        $subsection->content = $request->content;
        $subsection->save();

        broadcast(new SubsectionContentUpdated($subsection))->toOthers();

        return;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subsection $subsection)
    {
        //
    }
}
