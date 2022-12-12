<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Create new user
     *
     * @param array $objParam
     * @return User
     */
    public function createUser($objParam): User
    {
        $user = User::create($objParam);
        return $user;
    }

    /**
     * Update user
     *
     * @param array $objParam
     * @param string|int $id
     * @return User
     */
    public function updateUser($objParam, $id): User
    {
        $user = User::find($id);
        $user->update($objParam);
        return $user;
    }
}