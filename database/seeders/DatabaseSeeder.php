<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'kamil', // Changed from 'name' to 'first_name'
            'last_name' => 'michalski',
            'phone_number' => '123456789',
            'role' => Role::Admin,
            'email' => 'k@gmail',
            'password' => Hash::make('1234'),
        ]);
        User::factory()->create([
            'first_name' => 'user', // Changed from 'name' to 'first_name'
            'last_name' => 'testowy',
            'phone_number' => '123456789',
            'role' => Role::User,
            'email' => 't@t',
            'password' => Hash::make('1234'),
        ]);
        User::factory(50)->create();
        Visit::factory(50)->create();
    }
}
