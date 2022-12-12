<?php
namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    public function createUser(User $user)
    {
        $user->save();
    }
}