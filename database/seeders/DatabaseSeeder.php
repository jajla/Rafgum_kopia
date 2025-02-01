<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Visit;
use Database\Factories\VisitFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
         User::factory(40)->create();
         Visit::factory(40)->create();
    }
}
