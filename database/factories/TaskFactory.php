<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'assigned_to' => $this->faker->boolean() ? null : User::factory(),
            'title' => $this->faker->sentence(),
            'done_at' => $this->faker->boolean() ? fake()->dateTimeBetween('-1 year', 'now') : null,
        ];
    }
}
