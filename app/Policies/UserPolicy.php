<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/7 0007
 * Time: 19:21
 */

namespace App\Policies;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;

    public function delete(User $currentUser,User $user){
        return $currentUser->is_admin === 1 || $currentUser->id !== $user->id ;
    }
}