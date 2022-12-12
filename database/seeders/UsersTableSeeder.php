<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'email' => 'admin@admin.com',
            'name' => 'Administrator',
            'role' => User::ROLE_ADMIN,
            'password' => bcrypt('123456'),
        ]);
    }
}
