<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'book_id',
        'content',
    ];

    protected $with = ['subSections'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function subSections()
    {
        return $this->hasMany(SubSection::class);
    }
}
