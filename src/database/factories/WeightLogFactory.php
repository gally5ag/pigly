<?php

namespace Database\Factories;

use App\Models\WeightLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    protected $model = WeightLog::class;

    public function definition(): array
    {
       
        $mins = $this->faker->numberBetween(0, 120);
        $exerciseTime = sprintf('%02d:%02d:00', intdiv($mins, 60), $mins % 60);

        return [
            'date'             => $this->faker->dateTimeBetween('-120 days', 'today')->format('Y-m-d'),
            'weight'           => $this->faker->randomFloat(1, 45, 95), 
            'calories'         => $this->faker->numberBetween(1200, 3000),
            'exercise_time'    => $exerciseTime,                       
            'exercise_content' => $this->faker->optional()->sentence(8),
        ];
    }
}
