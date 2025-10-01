<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $param = [
            'name' => 'john',
            'email' => 'test1@email.com',
            'password' => Hash::make('coachtech'),
        ];

        DB::table('users')->insert($param);
    }
}
