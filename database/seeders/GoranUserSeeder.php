<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GoranUserSeeder extends Seeder
{
    /**
     * Seed a user account for Goran.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'goran@recode.hr'],
            [
                'name' => 'Goran',
                'email' => 'goran@recode.hr',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
    }
}
