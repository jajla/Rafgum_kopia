<?php

namespace Database\Factories;

use App\Enums\services;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::InRandomOrder()->first()->id,
            'date'=> now()->toDateString(),
            'time'=>now()->toTimeString(),
            'service_type'=>fake()->RandomElement(services::cases()),
        ];
    }
}
