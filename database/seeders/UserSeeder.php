<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->user()
            ->create([
                "email" => "user@test.com",
                "password" => \Hash::make("test1234"),
            ]);

        User::factory()
            ->admin()
            ->create([
                "email" => "admin@test.com",
                "password" => \Hash::make("test1234"),
            ]);
    }
}
