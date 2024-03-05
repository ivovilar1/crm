<?php

namespace Database\Factories;

use App\Traits\Factory\HasDeleted;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Opportunity>
 */
class OpportunityFactory extends Factory
{
    use HasDeleted;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['open', 'won', 'lost']),
            'amount' => $this->faker->numberBetween(1000,10000)
        ];
    }
}
