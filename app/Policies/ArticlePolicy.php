<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/7 0007
 * Time: 19:21
 */

namespace App\Policies;
use App\Models\Articles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class ArticlePolicy
{
    use HandlesAuthorization;

    public function delete(User $currentUser,Articles $articles){
        return $currentUser->is_admin === 1 || $currentUser->id === $articles->user_id;
    }

    public function update(User $currentUser,Articles $articles){
        return $currentUser->is_admin === 1 || $currentUser->id === $articles->user_id;
    }
}