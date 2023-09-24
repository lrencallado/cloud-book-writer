<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'section_id',
        'parent_id',
        'content',
    ];

    protected $with = ['childSubsections'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function childSubsections()
    {
        return $this->hasMany(Subsection::class, 'parent_id');
    }

    public function parentSubsection()
    {
        return $this->belongsTo(Subsection::class, 'parent_id');
    }
}
