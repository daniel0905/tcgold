<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Tam Duong',
            'email' => 'tam.duong@gmail.com',
            'password' => bcrypt('123456'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
