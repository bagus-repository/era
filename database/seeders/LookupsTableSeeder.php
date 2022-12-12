<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;

class LookupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        $lookup_data = [];

        foreach (['admin' => 'Admin', 'user' => 'User'] as $k => $v) {
            $lookup_data[] = [
                'category' => 'L_ROLE',
                'value' => $k,
                'desc' => $v,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        Lookup::insert($lookup_data);
    }
}
