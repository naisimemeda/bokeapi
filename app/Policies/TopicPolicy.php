<?php

namespace App\Policies;

use App\Models\Topics;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser,Topics $topics){
        return $currentUser->is_admin === 1;
    }
}
