<?php
declare(strict_types=1);

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

    protected $with = ['subsections'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function subsections()
    {
        return $this->hasMany(Subsection::class)->where('parent_id', null);
    }
}
