<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->withPermission('be an admin')
            ->create([
                'name'  => 'Admin',
                'email' => 'admin@crm.com',
            ]);
    }
}
