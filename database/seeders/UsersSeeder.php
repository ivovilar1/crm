<?php

namespace Database\Seeders;

use App\Models\Can;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create([
                'name'  => 'Admin',
                'email' => 'admin@crm.com',
            ]);
    }
}
