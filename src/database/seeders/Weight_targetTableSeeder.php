<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Weight_targetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = DB::table('users')->where('email', 'test@email.com')->value('id');

        DB::table('weight_targets')->updateOrInsert(
            ['user_id' => $userId],
            [
                'target_weight' => 60.0,  
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }
}
