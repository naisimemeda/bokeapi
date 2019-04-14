<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function delete(User $currentUser,Comment $comment){
        return $currentUser->is_admin === 1 || $currentUser->id === $comment->user_id;
    }
}
