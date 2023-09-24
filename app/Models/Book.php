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

    public function removeCollaborator(User $user)
    {
        $this->collaborators()->detach($user->id);
    }

    public function allCollaboratorRequests()
    {
        return $this->hasMany(CollaboratorRequest::class);
    }

    /**
     * Check if a user is a collaborator in the book.
     *
     * @param  User  $user
     * @return bool
     */
    public function isCollaborator(User $user)
    {
        return $this->collaborators->contains(function ($collaborator) use ($user) {
            return $collaborator->id === $user->id && $collaborator->pivot->role === 'Collaborator';
        });
    }
}
