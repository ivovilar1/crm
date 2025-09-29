<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::query()->where('id', '<', 10)->get()
            ->each(function (Customer $customer) {
                Task::factory()->count(rand(1, 10))->create([
                    'customer_id' => $customer->id,
                ]);
            });
    }
}
