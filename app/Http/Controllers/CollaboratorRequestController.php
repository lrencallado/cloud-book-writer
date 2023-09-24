<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CollaboratorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollaboratorRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Collaborator/Index', [
            'collaborators' => $request->user()->authorCollaboratorRequests()->paginate(),
        ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required'
        ]);

        $book = Book::where('id', $request->book_id)->with('collaborators')->first();
        $collaborators = $book->collaborators()->get();
        $author = $collaborators->where('pivot.role', 'Author')->first();

        CollaboratorRequest::create([
            'book_id' => $book->id,
            'requestor_id' => $request->user()->id,
            'author_id' => $author->id,
            'status' => 'Pending',
        ]);

        return Inertia::location('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(CollaboratorRequest $collaboratorRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CollaboratorRequest $collaboratorRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CollaboratorRequest $collaboratorRequest)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $collaborator = User::findOrFail($collaboratorRequest->requestor_id);
        $book = Book::findOrFail($collaboratorRequest->book_id);

        if ($request->status == 'Approved') {
            $book->addCollaborator($collaborator);
        } else if ($request->status == 'Revoked') {
            $book->removeCollaborator($collaborator);
        }

        $collaboratorRequest->status = $request->status;
        $collaboratorRequest->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CollaboratorRequest $collaboratorRequest)
    {
        //
    }
}
