<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'book_users')->withPivot('role');
    }

    public function addCollaborator(User $user, $role = 'Collaborator')
    {
        $this->collaborators()->attach($user->id, ['role' => $role]);
    }
}
