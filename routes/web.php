<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CollaboratorRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PusherAuthController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubsectionController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $books = Book::orderByDesc('created_at')->with('collaborators');

    // We'll not display the collaborator requests publicly
    if ($request->user()) {
        $books->with('allCollaboratorRequests');
    }

    $books = $books->paginate();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'books' => $books,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('books', BookController::class);
    Route::resource('books.sections', SectionController::class);
    Route::resource('books.sections.subsections', SubsectionController::class);

    Route::resource('collaborator-request', CollaboratorRequestController::class);

    Route::post('/broadcasting/auth', [PusherAuthController::class, 'auth']);
});


require __DIR__.'/auth.php';
