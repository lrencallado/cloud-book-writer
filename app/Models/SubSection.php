<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'section_id',
        'content',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function childSubsections()
    {
        return $this->hasMany(Subsection::class, 'section_id');
    }
}
