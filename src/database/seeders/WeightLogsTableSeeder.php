<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WeightLog;

class WeightLogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = DB::table('users')->where('email', 'test1@email.com')->value('id');
        WeightLog::factory()
            ->count(35)
            ->state(['user_id' => $userId])
            ->create();
    }
}
