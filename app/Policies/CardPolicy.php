<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class CardPolicy
{
    use HandlesAuthorization;

    public function interact(User $user) {
        return $user->user_type_id === UserType::ADMIN_ID;
    }
}
