<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaboratorRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requestor_id',
        'author_id',
        'book_id',
        'status',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function book()
    {
        $this->belongsTo(Book::class);
    }
}
